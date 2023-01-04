<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Students">
                    <div class="card-header">
                        <h4 class="card-title">Öğrenciye Göre  Kurs Satışları
                        </h4>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="datatable table table-stripped">
                                <thead>
                                    <tr>
                                        <th class="text-center">Ay-Yıl</th>
                                        <th class="text-center">Kurs Adı</th>
                                        <th class="text-center">Satın Alınan Kurs Sayısı</th>
                                        <th class="text-center">Kurs Satış Toplam</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $GetReportByStudents = $connection->prepare("SELECT 
                                    COUNT(*) AS Count,
                                    SUM(tblorders.tblOrderTotalAmount) AS TotalAmount,
                                    MONTH(tblorders.tblOrderCreatedDate) AS Month,
                                    YEAR(tblorders.tblOrderCreatedDate) AS Year,
                                    tblstudents.tblStudentFirstname AS Firstname,
                                    tblstudents.tblStudentLastname AS Lastname
                                    FROM tblorders
                                    INNER JOIN tblstudents ON tblorders.tblOrderStudentId=tblstudents.tblStudentId
                                    GROUP BY Month, tblstudents.tblStudentId");
                                    $GetReportByStudents->execute();
                                    foreach ($GetReportByStudents->fetchAll() as $GetReport) {?>

                                    <tr>
                                        <td class="text-center"><?php echo $GetReport["Month"] . "/" . $GetReport["Year"]; ?></td>
                                        <td class="text-center"><?php echo $GetReport["Firstname"] . " " . $GetReport["Lastname"]; ?></td> </td>
                                        <td class="text-center"><?php echo $GetReport["Count"]; ?></td>
                                        <td class="text-center"><?php echo $GetReport["TotalAmount"]." ₺"; ?></td>
                                        
                                    </tr>
                                    <?php   }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
<?php require_once("Footer.php"); ?>