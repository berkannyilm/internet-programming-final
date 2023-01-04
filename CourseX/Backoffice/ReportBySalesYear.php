<?php require_once("Header.php"); ?>

<div class="page-wrapper">
    <div class="content container-fluid">

        <div class="row">
            <div class="col-sm-12">
                <div class="card" id="Students">
                    <div class="card-header">
                        <h4 class="card-title">Yıllık Kurs Satışları
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
                                    $GetReportBySalesYear = $connection->prepare("SELECT 
                                    COUNT(*) AS Count,
                                    SUM(tblorders.tblOrderTotalAmount) AS TotalAmount, 
                                    YEAR(tblorders.tblOrderCreatedDate) AS Year,
                                    tblcourses.tblCourseTitle AS CourseTitle
                                    FROM tblorders
                                    INNER JOIN tblcourses ON tblorders.tblOrderCourseId=tblcourses.tblCourseId
                                    GROUP BY Year, tblcourses.tblCourseId  ");
                                    $GetReportBySalesYear->execute();
                                    foreach ($GetReportBySalesYear->fetchAll() as $GetReport) {?>

                                    <tr>
                                        <td class="text-center"><?php echo $GetReport["Year"]; ?></td>
                                        <td class="text-center"><?php echo $GetReport["CourseTitle"]; ?></td>
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