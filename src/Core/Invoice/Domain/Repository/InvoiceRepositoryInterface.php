<?php

namespace App\Core\Invoice\Domain\Repository;

use App\Core\Invoice\Domain\Invoice;

interface InvoiceRepositoryInterface
{
    /**
     * @return Invoice[]
     */
    public function getInvoicesWithGreaterAmountAndStatus(string $invoiceStatus, int $amount): array;

    public function save(Invoice $invoice): void;

    public function flush(): void;
}
