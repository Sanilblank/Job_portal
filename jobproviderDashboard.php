<?php
require 'includes/jobprovider_header.php';
require 'controllers/authController.php';
?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">
                <h2 class="h2heading">Datatable containing all your advertised jobs</h2>
            </div>
            <div class="col-md-11 offset-md-4 divTable">
                <div class="container mb-3 mt-3">
                    <table class="table table-striped mydatatable" style="width: 100%">
                        <thead class="thead-dark">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Cat</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Dog</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Panda</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Lion</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>
                            <tr>
                                <td>Tiger</td>
                                <td>King</td>
                                <td>Tahachal</td>
                                <td>16</td>
                                <td>2020/01/01</td>
                                <td>$40000</td>
                            </tr>

                        </tbody>
                        <tfoot>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Office</th>
                            <th>Age</th>
                            <th>Start date</th>
                            <th>Salary</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('.mydatatable').DataTable();
</script>



<?php
require 'includes/jobprovider_footer.php';
?>