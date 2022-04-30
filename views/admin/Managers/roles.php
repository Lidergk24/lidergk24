<?php include ROOT . '/views/admin/Index/Header.php'; ?>
<main class="main-cabinet-user main-cabinet-user-view main-cabinet-admin">
    <div class="container">
        <div class="cabinet-sidebar">
            <div class="btn-close__menu"></div>
            <?php include ROOT . '/views/admin/Index/Sidebar.php'; ?>
        </div>
        <div class="main-cabinet-user__content main-cabinet-admin__content">
            <ul class="breadcrumb breadcrumb-cabinet">
                <li><a href="/admin" title="Главная"><span>ГЛАВНАЯ</span></a></li>
                <li><a title="Права пользователей"><span>Права пользователей</span></a></li>
            </ul>
            <h1>Права пользователей</h1>
            <div class="main-cabinet-button__group">
            </div>
            <div class="sales-table__admin managers-table table w-100">
                <div class="table__head">
                    <div class="table__th managers-table__phone">Телефон</div>
                    <div class="table__th managers-table__phone-add">Имя</div>
                    <div class="table__th managers-table__mail">Права доступа</div>
                    <div class="table__th managers-table__photo">Удалить</div>
                </div>
                <div class="table__body">

                    <?php foreach ($users as $user) { ?>
                        <div class="table-body_line">
                            <div class="table__td managers-table__phone">
                                <p><?php echo $user['phone']; ?></p>
                            </div>
                            <div class="table__td managers-table__phone-add">
                                <p><?php echo $user['name']; ?></p>
                            </div>
                            <div class="table__td managers-table__mail">
                                <p><?php echo $user['role']; ?></p>
                            </div>
                            <div class="table__td managers-table__photo">
                                <p class="idRole" data-id="<?php echo $user['id']; ?>">x</p>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="table__body">
                    <div class="table-body_line" id='addOperatorForm'>
                        <div class="table__td managers-table__phone">
                            <input type='text' name='phone'></input>
                        </div>
                        <div class="table__td managers-table__phone-add">
                            <input type='text' name='name'></input>
                        </div>
                        <div class="table__td managers-table__mail">
                            <select name='role' style="width: 100%;height: 100%;border: none;text-align-last: center;">
                                <option>admin</option>
                                <option>operator</option>
                            </select>
                        </div>

                        <button class="table__td managers-table__photo">
                            <p class="RoleAdd" style='font-weight: 600; width: 100%; height: 100%;font-size: 1rem;padding:10%'>Добавить</p>
                        </button>
                    </div>
                </div>
            </div>
        </div>
</main>
<?php include ROOT . '/views/admin/Index/Footer.php'; ?>
<script>
    $('.idRole').on('click', function() {

        var idM = $(this).closest('.idRole').attr('data-id');

        var isGood = confirm('Убрать права?');

        if (isGood == true) {

            $.ajax({

                url: 'removeRole',
                type: 'post',
                data: {
                    id: idM
                },

                success: function(data) {

                    location.reload();

                }
            });
        }

    });
    $('.RoleAdd').on('click', function() {

        var name = $('input[name="name"]').val();
        var phone = $('input[name="phone"]').val();
        var role = $('select[name="role"]').val();

        $.ajax({

            url: 'addRole',
            type: 'post',
            data: {
                name: name,
                phone: phone,
                role: role
            },

            success: function(data) {

                location.reload();

            }
        });


    });
</script>