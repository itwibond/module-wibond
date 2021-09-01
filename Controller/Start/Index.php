<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Controller\Start;

use Magento\Checkout\Model\Session;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\UrlInterface;
use Magento\Sales\Api\OrderRepositoryInterface;
use Wibond\Wibond\Api\Data\PaymentLinkOptionsInterface;
use Wibond\Wibond\Api\Data\PaymentLinkOptionsInterfaceFactory;
use Wibond\Wibond\Api\Data\PaymentLinkRequestInterface;
use Wibond\Wibond\Api\Data\PaymentLinkRequestInterfaceFactory;
use Wibond\Wibond\Config\Config;
use Wibond\Wibond\Model\Logger;
use Wibond\Wibond\Model\WibondApi;

class Index implements HttpGetActionInterface
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var RedirectFactory
     */
    private RedirectFactory $redirectFactory;

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var Session
     */
    private Session $checkoutSession;

    /**
     * @var PaymentLinkRequestInterfaceFactory
     */
    private PaymentLinkRequestInterfaceFactory $paymentLinkRequestFactory;

    /**
     * @var PaymentLinkOptionsInterfaceFactory
     */
    private PaymentLinkOptionsInterfaceFactory $optionsFactory;

    /**
     * @var Config
     */
    private Config $config;

    /***
     * @var WibondApi
     */
    private WibondApi $wibondApi;

    /**
     * @var UrlInterface
     */
    private UrlInterface $urlBuilder;

    /**
     * @param Logger $logger
     * @param RedirectFactory $redirectFactory
     * @param OrderRepositoryInterface $orderRepository
     * @param Session $checkoutSession
     * @param PaymentLinkRequestInterfaceFactory $paymentLinkRequestFactory
     * @param PaymentLinkOptionsInterfaceFactory $optionsFactory
     * @param Config $config
     * @param WibondApi $wibondApi
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        Logger $logger,
        RedirectFactory $redirectFactory,
        OrderRepositoryInterface $orderRepository,
        Session $checkoutSession,
        PaymentLinkRequestInterfaceFactory $paymentLinkRequestFactory,
        PaymentLinkOptionsInterfaceFactory $optionsFactory,
        Config $config,
        WibondApi $wibondApi,
        UrlInterface $urlBuilder
    ) {
        $this->logger = $logger;
        $this->redirectFactory = $redirectFactory;
        $this->orderRepository = $orderRepository;
        $this->checkoutSession = $checkoutSession;
        $this->paymentLinkRequestFactory = $paymentLinkRequestFactory;
        $this->optionsFactory = $optionsFactory;
        $this->config = $config;
        $this->wibondApi = $wibondApi;
        $this->urlBuilder = $urlBuilder;
    }

    /**
     * @return ResultInterface
     */
    public function execute()
    {
        // Obtener el order
        $order = $this->orderRepository->get($this->checkoutSession->getLastOrderId());
        $payment = $order->getPayment();

        /** @var PaymentLinkRequestInterface $paymentLinkRequest */
        $paymentLinkRequest = $this->paymentLinkRequestFactory->create();
        $enabledOptions = $this->config->getPaymentOptions();
        $planOptions = [];
        $wibondApiData = $this->wibondApi->getFinancialPlanOptions();
        foreach ($wibondApiData[WibondApi::FINANCIAL_OPTIONS_KEY] as $option) {
            $planOptions[$option['id']] = $option;
        }

        foreach ($enabledOptions as $option) {
            /** @var PaymentLinkOptionsInterface $optionRequest */
            $optionRequest = $this->optionsFactory->create();
            $financialPlan = $planOptions[$option] ?? null;
            if ($financialPlan === null) {
                continue;
            }
            $optionRequest->setId($financialPlan['id'])
                ->setCode($financialPlan['code']);
            $paymentLinkRequest->addOption($optionRequest);
        }
        // Obtener los datos del order
        $resumeTitle = $this->config->getValue('resume_title');
        $resumeTitle = preg_replace('/\%1/', $order->getIncrementId(), $resumeTitle);

        $paymentLinkRequest->setAmount((float) $payment->getAmountOrdered())
            ->setExternalId($order->getIncrementId())
            ->setProductName($resumeTitle)
            ->setUrlError($this->urlBuilder->getUrl('checkout/onepage/failure'))
            ->setUrlSuccess($this->urlBuilder->getUrl('checkout/onepage/success'))
            ->setUrlNotification($this->urlBuilder->getUrl('wibond/notification'));

        $this->logger->log('Payment request', $paymentLinkRequest->toArray());

        // Generar link de pago
        $wibondData = $this->wibondApi->getPayUrl($paymentLinkRequest);

        // Setear state del order
        $state = $this->config->getValue('order_status');

        // Guardar datos del link de pago en el order
        $this->logger->log('Mensaje', (array) $wibondData);
        $payment->setAdditionalInformation(Config::KEY_WIBOND_LINK_ID, $wibondData['id']);
        $order->addCommentToStatusHistory(__('Customer is redirected to %1', $wibondData['urlLink']), $state);
        $this->orderRepository->save($order);

        // Redireccionar
        $resultRedirect = $this->redirectFactory->create();
        $this->logger->log($wibondData['urlLink']);
        $resultRedirect->setUrl($wibondData['urlLink']);

        return $resultRedirect;
    }
}
