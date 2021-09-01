<?php
/**
 * Wibond_Wibond
 *
 * @copyright  Copyright (c) 2021 Wibond. (https://www.wibond.com.ar/)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Wibond\Wibond\Controller\Notification;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\CsrfAwareActionInterface;
use Magento\Framework\App\Request\InvalidRequestException;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\DB\TransactionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Webapi\Rest\Request;
use Magento\Sales\Api\OrderRepositoryInterface;
use Magento\Sales\Model\Order;
use Magento\Sales\Model\Order\Email\Sender\InvoiceSender;
use Magento\Sales\Model\Order\Payment;
use Magento\Sales\Model\OrderFactory;
use Magento\Sales\Model\Service\InvoiceService;
use Wibond\Wibond\Config\Config;
use Wibond\Wibond\Model\Logger;
use Wibond\Wibond\Model\Payment\Wibond;

class Index implements HttpPostActionInterface, HttpGetActionInterface, CsrfAwareActionInterface
{
    /**
     * @var Logger
     */
    private Logger $logger;

    /**
     * @var JsonFactory
     */
    private JsonFactory $resultJsonFactory;

    /**
     * @var Request
     */
    private Request $request;

    /**
     * @var OrderFactory
     */
    private OrderFactory $orderFactory;

    /**
     * @var Config
     */
    private Config $config;

    /**
     * @var OrderRepositoryInterface
     */
    private OrderRepositoryInterface $orderRepository;

    /**
     * @var TransactionFactory
     */
    private TransactionFactory $transactionFactory;

    /**
     * @var InvoiceSender
     */
    private InvoiceSender $invoiceSender;

    /**
     * @var InvoiceService
     */
    private InvoiceService $invoiceService;

    /**
     * @param Logger $logger
     * @param JsonFactory $resultJsonFactory
     * @param Request $request
     * @param OrderFactory $orderFactory
     * @param Config $config
     * @param OrderRepositoryInterface $orderRepository
     * @param TransactionFactory $transactionFactory
     * @param InvoiceSender $invoiceSender
     * @param InvoiceService $invoiceService
     */
    public function __construct(
        Logger $logger,
        JsonFactory $resultJsonFactory,
        Request $request,
        OrderFactory $orderFactory,
        Config $config,
        OrderRepositoryInterface $orderRepository,
        TransactionFactory $transactionFactory,
        InvoiceSender $invoiceSender,
        InvoiceService $invoiceService
    ) {
        $this->logger = $logger;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->orderFactory = $orderFactory;
        $this->config = $config;
        $this->orderRepository = $orderRepository;
        $this->transactionFactory = $transactionFactory;
        $this->invoiceSender = $invoiceSender;
        $this->invoiceService = $invoiceService;
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
        $data = $this->request->getBodyParams();
        $this->logger->log('Notification response', $data);

        $orderId = $data['externalId'];
        if (!$orderId) {
            $this->logger->log('Invalid Order Id', [$data['externalId']]);
            throw new LocalizedException(__('Invalid Order Id'));
        }
        /** @var Order $order */
        $order = $this->orderFactory->create()->loadByIncrementId($orderId);
        if (!$order->getId()) {
            $this->logger->log('The Order was not found', [$orderId]);
            throw new LocalizedException(__('The Order was not found'));
        }

        if (!$order->getTotalDue()) {
            $this->logger->log('The Order has been paid');
            throw new LocalizedException(__('The Order has been paid'));
        }

        /** @var Payment $payment */
        $payment = $order->getPayment();

        $paymentLinkId = $payment->getAdditionalInformation(Config::KEY_WIBOND_LINK_ID);
        if ($paymentLinkId !== $data['relatedPaymentLinkId']) {
            $this->logger->log('Invalid payment link id', [$paymentLinkId]);
            throw new LocalizedException(__('Invalid payment link id'));
        }
        $status = $data['status'];
        $this->logger->log('New status will be', [$status]);
        $isOk = in_array($status, [
            Wibond::WIBOND_STATUS_PENDING,
            Wibond::WIBOND_STATUS_IN_PROGRESS,
            Wibond::WIBOND_STATUS_COMPLETED
        ]);
        $state = $isOk ? $this->config->getStatusPay() : $this->config->getStatusRejected();
        $additionalInfo = [$isOk ? __('The paid has been accepted') : __('The pay has been rejected')];
        $additionalInfo[] = __('Notification ID %1', $data['id']);
        if (isset($data['paymentLinkFinancialPlan']) && $data['paymentLinkFinancialPlan']['optionPlan']) {
            $additionalInfo[] = __('The customer choose %1', $data['paymentLinkFinancialPlan']['optionPlan']['name']);
        }

        $order->setState(Order::STATE_PROCESSING)
            ->addCommentToStatusHistory(implode('<br/>', $additionalInfo), $state);

        if ($isOk) {
            $invoice = $this->invoiceService->prepareInvoice($order);
            $invoice->register();
            $invoice->pay();
            $invoice->save();

            $transaction = $this->transactionFactory->create();
            $transaction->addObject($invoice);
            $transaction->addObject($invoice->getOrder());
            $transaction->save();

            $this->invoiceSender->send($invoice);
            $this->logger->log('Order is OK');
        } else {
            $order->cancel();
            $this->orderRepository->save($order);
            $this->logger->log('Order cancelled');
        }

        return $this->resultJsonFactory->create();
    }

    /**
     * @inheritDoc
     */
    public function createCsrfValidationException(RequestInterface $request): ?InvalidRequestException
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function validateForCsrf(RequestInterface $request): ?bool
    {
        return true;
    }
}
