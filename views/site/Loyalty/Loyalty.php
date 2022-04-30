<?php include ROOT . '/views/layouts/header.php'; ?>

    <main class="sale-main loyalty-main">
        <div class="container">
            <?php include ROOT . '/views/layouts/sidebar_menu.php'; ?>
            <div class="main-wrapper">
                <div class="breadcrumb-wrapper">
                    <ul class="breadcrumb">
                        <li><a href="/">Главная </a></li>
                        <li><span>Программа лояльности</span></li>
                    </ul>
                </div>
                <div class="loyalty-main__box">
                    <h1>Как это работает?</h1>
                    <div class="box-text">
                        <p>Наша накопительная программа лояльности работает для всех клиентов компании.</p>
                        <p>В программе могут участвовать физические и юридические лица.</p>
                        <p>Совершайте заказы на постоянной основе, получайте накопительную скидку, бесплатную доставку и
                            доступ
                            к эксклюзивным акциям.</p>
                    </div>
                </div>

                <div class="loyalty-stages-wrapper">
                    <div class="loyalty-stages__box">
                        <div class="loyalty-stages__box-icon"><img src="/template/images/Icons/loyalti1.png" alt="">
                        </div>
                        <div class="loyalty-stages__box-content">
                            <p>Зарегистрируйтесь на сайте как
                                физическое или юридическое лицо.
                            </p>
                        </div>
                    </div>

                    <div class="loyalty-stages__box">
                        <div class="loyalty-stages__box-icon"><img src="/template/images/Icons/loyalti2.png" alt="">
                        </div>
                        <div class="loyalty-stages__box-content">
                            <p>Подайте заявку на участие в программе
                                лояльности и ожидайте ее подтверждения.
                            </p>
                        </div>
                    </div>

                    <div class="loyalty-stages__box">
                        <div class="loyalty-stages__box-icon"><img src="/template/images/Icons/loyalti3.png" alt="">
                        </div>
                        <div class="loyalty-stages__box-content">
                            <p>Будь лидером с Лидером!</p>
                            <p>Совершайте заказы, накапливайте скидку
                                и получайте доступ к эксклюзивным акциям.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="loyalty-status">
                    <h2>Статусы клиентов компании</h2>

                    <div class="loyalty-status__wrapper">
                        <div class="loyalty-status__box">
                            <div class="loyalty-status__card">
                                <div class="loyalty-status__card-percent">
                                    <p>5%</p>
                                </div>

                                <div class="loyalty-status__card-content">
                                    <div class="loyalty-status__card-name">BEGINNER</div>
                                    <p>10 000 - 50 000</p>
                                </div>
                            </div>

                            <div class="loyalty-status__box-description">
                                Скидка <strong>5%</strong> при общей сумме месячных
                                заказов <strong>от 10 000 до 50 000</strong> ₽
                            </div>
                        </div>
                        <div class="loyalty-status__box">
                            <div class="loyalty-status__card">
                                <div class="loyalty-status__card-percent">
                                    <p>10%</p>
                                </div>

                                <div class="loyalty-status__card-content">
                                    <div class="loyalty-status__card-name">INSIDER</div>
                                    <p>50 000 - 100 000</p>
                                </div>
                            </div>

                            <div class="loyalty-status__box-description">
                                Скидка <strong>10%</strong> при общей сумме месячных
                                заказов <strong>от 50 000 до 100 000</strong> ₽
                            </div>
                        </div>

                        <div class="loyalty-status__box">
                            <div class="loyalty-status__card">
                                <div class="loyalty-status__card-percent">
                                    <p>15%</p>
                                </div>

                                <div class="loyalty-status__card-content">
                                    <div class="loyalty-status__card-name">LEADER</div>
                                    <p>от 100 000</p>
                                </div>
                            </div>

                            <div class="loyalty-status__box-description">
                                Скидка <strong>15%</strong> при общей сумме месячных
                                заказов <strong>от 100 000</strong> ₽
                            </div>
                        </div>
                    </div>
                    <?php if (User::isGuest()){ ?>
                    <a href="/user/register" class="btn btn_red">Присоединиться</a>
                    <?php } ?>
                </div>

            </div>
        </div>
    </main>
    


<?php include ROOT . '/views/layouts/footer.php'; ?>