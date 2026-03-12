<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <x-dashboard-summary-card title="Total Income" icon="fa-solid fa-arrow-trend-up"
        main_parameter="{{ number_format($totalIncome / 1000, 2) }} TND" change_unit="none" />

    <x-dashboard-summary-card title="Total Expenses" icon="fa-solid fa-arrow-trend-down"
        main_parameter="{{ number_format($totalExpense / 1000, 2) }} TND" change_unit="none" />
</div>
