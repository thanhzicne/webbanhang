<?php include 'app/views/shares/header.php'; ?>

<div class="mt-4 p-5 text-white rounded-3 my-4 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(90deg, #20b2aa, #4169e1);">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" style="background: url('https://www.transparenttextures.com/patterns/symphony.png');"></div>
    <h1 class="text-center mb-4 text-white fw-bold position-relative" style="font-family: 'Poppins', sans-serif; font-size: 2.5rem; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);">
        <i class="fas fa-chart-line me-3"></i> Thống kê doanh thu
    </h1>
</div>

<?php
$sections = [
    'dailyStats' => '🔹 Doanh thu theo ngày',
    'weeklyStats' => '🔹 Doanh thu theo tuần',
    'monthlyStats' => '🔹 Doanh thu theo tháng',
    'yearlyStats' => '🔹 Doanh thu theo năm'
];
?>

<?php foreach ($sections as $key => $title): ?>
    <div class="mb-5">
        <h4 class="fw-bold mb-3" style="color: #333; font-family: 'Poppins', sans-serif;"><?= $title ?></h4>
        <div class="table-responsive rounded shadow-sm">
            <table class="table table-striped table-hover table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col" class="text-center"><?= explode(' ', $title)[count(explode(' ', $title)) - 1] ?></th>
                        <th scope="col" class="text-center">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($$key)): ?>
                        <tr>
                            <td colspan="2" class="text-center text-muted py-4">
                                <i class="fas fa-info-circle me-2"></i> Không có dữ liệu thống kê.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($$key as $row): ?>
                            <tr style="line-height: 1.5;">
                                <td class="text-center"><?= htmlspecialchars($row['label'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="text-end fw-semibold"><?= number_format($row['revenue'], 0, ',', '.') ?> đ</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endforeach; ?>

<?php include 'app/views/shares/footer.php'; ?>
