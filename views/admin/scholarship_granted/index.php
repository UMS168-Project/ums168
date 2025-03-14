<?php
ob_start();
require_once '../../../config/config.php';
require_once '../../../connection/db.php';
$title = "List ";
?>

<h4 class="fw-bold mb-2 d-flex justify-content-between align-items-center">
    បញ្ជី ការផ្តល់អាហាររូករណ៍
    <a href="create.php" style="font-size:25px;" class="text-primary">
        <i class="bi bi-plus-square-fill "></i>
    </a>
</h4>
<div class="card">
    <div class="card-body">
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered table-sm">
                <thead class="table-secondary text-center">
                    <tr>
                        <th>
                            ល.រ
                        </th>
                        <th>
                            អាហាររូករណ៍
                        </th>
                        <th>
                            និសិត្ស
                        </th>
                        <th>
                            ឆ្នាំ
                        </th>
                        <th>
                            ស្នើរដោយ
                        </th>
                        <th>
                            ចំនួន
                        </th>
                        <th>
                            កាលបរិច្ឆេទ
                        </th>
                        <th>
                            ស្ថានភាព
                        </th>
                        <th>
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        $select_row = "SELECT 
                                        sch.SchGrantedID, 
                                        sch.ScholarshipID, 
                                        sch.Amount, 
                                        sch.RequestedBy,
                                        sch.IsContinue,
                                        sch.GrantedDate,
                                        st.NameInKhmer,
                                        sl.Scholarship,
                                        y.YearNameKH
                                    FROM 
                                        ScholarGranted_Tbl sch
                                    INNER JOIN 
                                        Scholarship_Tbl sl ON sch.ScholarshipID = sl.ScholarshipID
                                    INNER JOIN 
                                        tblyear y ON sch.YearID = y.YearID
                                    INNER JOIN
                                        tblstudentinfo st ON sch.StudentID = st.StudentID";
                        $result = mysqli_query($conn, $select_row);
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td class='text-center'>" . $row['SchGrantedID'] . "</td>";
                            echo "<td>" . $row['Scholarship'] . "</td>";
                            echo "<td>" . $row['NameInKhmer'] . "</td>";
                            echo "<td>" . $row['YearNameKH'] . "</td>";
                            echo "<td>" . $row['RequestedBy'] . "</td>";
                            echo "<td>" . "$ ".  $row['Amount'] . "</td>";
                            echo "<td>" . $row['GrantedDate'] . "</td>";
                            // echo "<td>" . $row['IsContinue'] . "</td>";
                            // echo "<td>" . ($row['IsContinue'] == 1 ? 'Active' : 'Inactive') . "</td>";
                            echo "<td class='text-center'><span class='" . ($row['IsContinue'] == 1 ? 'btn btn-sm btn-outline-success' : 'btn btn-sm btn-outline-danger') . "'>" . 
                            ($row['IsContinue'] == 1 ? 'Active' : 'Inactive') . 
                            "</span></td>";

                            ?>
                        <td class="text-center">
                            <a href="edit.php?id=<?php echo $row['SchGrantedID']; ?>">
                                <i class="bx bxs-edit"></i>
                            </a>
                            &nbsp;
                            <a href="javascript:void(0);" class="btnDelete"
                                data-id="<?php echo $row['SchGrantedID']; ?>" style="color:red;" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="bx bxs-trash"></i>
                            </a>
                        </td>
                        <?php
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
        <nav aria-label="..." class="mt-2">
            <ul class="pagination pagination-sm">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item " aria-current="page">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<!-- Script confirm delete -->
<script>
$(document).ready(function() {
    $('.btnDelete').on('click', function() {
        var deleteId = $(this).data('id');
        var deleteUrl = '<?php echo BASE_URL ?>actions/ScholarshipGrantedAction.php?id=' + deleteId;
        $('#confirmDelete').attr('href', deleteUrl);
    });
});
</script>
<?php
    $content = ob_get_clean();
    include BASE_PATH . 'views/admin/master.php';
?>