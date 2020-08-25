<?php
require 'includes/jobprovider_header.php';
require 'controllers/authController.php';
?>


<section>
    <div class="container">
        <div class="row">
            <div class="col-md-11 offset-md-4 heading">
                <?php if (count($errors) > 0) { ?>
                    <div class="alert alert-danger">
                        <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                        <?php foreach ($errors as $error) { ?>
                            <?php echo $error  . "<br>" ?>
                        <?php } ?>
                    </div>
                <?php } ?>

                <h2 class="h2heading">Datatable containing all your advertised jobs</h2>
            </div>
            <div class="col-md-11 offset-md-4 divTable">

                <!-- Modal -->
                <div class="modal fade" id="addjobmodel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="exampleModalLabel">Add New Job Title</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="jobproviderDashboard.php" method="POST">
                                <div class="modal-body">
                                    <!-- To be displayed in modal -->

                                    <div class="form-group">
                                        <label for="recruiter">Recruiter or Company Name</label>
                                        <input type="text" name="recruiter" class="form-control" placeholder="Enter Name of Recruiter or Company" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Job Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title of Job" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="salary">Salary</label>
                                        <input type="text" name="salary" class="form-control" placeholder="Enter Salary" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" placeholder="Enter Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="location">Location</label>
                                        <input type="text" name="location" class="form-control" placeholder="Enter Location" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" name="addjob" class="btn btn-primary">Save Data</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Modal end -->
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addjobmodel">
                    Add New Job Title
                </button>

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