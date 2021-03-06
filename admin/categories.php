<?php include('db_connect.php'); ?>

<div class="container-fluid">

    <div class="col-lg-12">
        <div class="row">
            <!-- FORM Panel -->
            <div class="col-md-4">
                <form action="" id="manage-category">
                    <div class="card">
                        <div class="card-header">
                            Medical Specialties Form
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="id">

                            <!--  Upload Doctor Specialty-->
                            <div class="form-group">
                                <label class="control-label">Specialty</label>
                                <textarea name="name" id="" cols="30" rows="2" class="form-control"></textarea>
                            </div>

                            <!--  Upload Doctor Specialty Image-->
                            <div class="form-group">
                                <label for="" class="control-label">Image</label>
                                <input type="file" class="form-control" name="img" onchange="displayImg(this, $(this))">
                            </div>

                            <!--  Display of uploaded Doctor Specialty Image-->
                            <div class="form-group">
                                <img src="" alt="" id="cimg">
                            </div>

                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-sm btn-primary col-sm-3 offset-md-3"> Save</button>
                                    <button class="btn btn-sm btn-danger col-sm-3" type="reset"> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- FORM Panel -->

            <!-- Table Panel -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">Image</th>
                                <th class="text-center">Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $i = 1;
                            $cats = $conn->query("SELECT * FROM medical_specialty order by id asc");
                            while ($row = $cats->fetch_assoc()):
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++ ?></td>

                                    <!--  Uploaded Doctor Specialty Image-->
                                    <td class="text-center">
                                        <img src="../assets/img/<?php echo $row['img_path'] ?>" alt="">
                                    </td>

                                    <!--  Uploaded Doctor Specialty-->
                                    <td class="">
                                        <b><?php echo $row['name'] ?></b>
                                    </td>

                                    <!--  Actions-->
                                    <td class="text-center">

                                        <!-- edit action-->
                                        <button class="btn btn-sm btn-primary edit_cat" type="button"
                                                data-id="<?php echo $row['id'] ?>"
                                                data-name="<?php echo $row['name'] ?>"
                                                data-img_path="<?php echo $row['img_path'] ?>">Edit
                                        </button>

                                        <!-- delete action-->
                                        <button class="btn btn-sm btn-danger delete_cat" type="button"
                                                data-id="<?php echo $row['id'] ?>">Delete
                                        </button>

                                    </td>
                                </tr>
                            <?php endwhile; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Table Panel -->
        </div>
    </div>

</div>
<style>

    td {
        vertical-align: middle !important;
    }

    td p {
        margin: unset
    }

    img {
        max-width: 100px;
        max-height: 150px;
    }
</style>
<script>


    $('#manage-category').submit(function (e) {
        e.preventDefault();
        start_load();

        $.ajax({
            url: 'ajax.php?action=save_category',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',

            success: function (response) {
                if (response == 1) {
                    alert_toast("Data has been successfully added.", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                } else if (response == 2) {
                    alert_toast("Data has been successfully updated.", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                }
            }
        });
    });

    $('.edit_cat').click(function () {
        start_load();
        const cat = $('#manage-category');
        cat.get(0).reset();
        cat.find("[name='id']").val($(this).attr('data-id'));
        cat.find("[name='name']").val($(this).attr('data-name'));
        cat.find("#cimg").attr("src", "../assets/img/" + $(this).attr('data-img_path'));
        end_load();
    });

    $('.delete_cat').click(function () {
        _conf("Are you certain you want to delete this medical specialty?", "delete_cat", [$(this).attr('data-id')]);
    });

    function displayImg(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (read) {
                $('#cimg').attr('src', read.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    function delete_cat($id) {
        start_load();

        $.ajax({
            url: 'ajax.php?action=delete_category',
            method: 'POST',
            data: {id: $id},
            success: function (resp) {
                if (resp == 1) {
                    alert_toast("Data has been successfully deleted.", 'success');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                }
            }
        });
    }
</script>