<?php echo $this->render('partials/main'); ?>

    <head>

        <?php echo $this->render('partials/title-meta', array('title'=>'Job Landing')); ?>

        <!--Swiper slider css-->
        <link href="/libs/swiper/swiper-bundle.min.css" rel="stylesheet" type="text/css" />

        <?php echo $this->render('partials/head-css'); ?>

    </head>

    <body data-bs-spy="scroll" data-bs-target="#navbar-example">

        <!-- Begin page -->
        <div class="layout-wrapper landing">
            <!-- start navbar -->
             <?php echo $this->render('website/navigation'); ?>
            <!-- end navbar -->

            <!-- start hero section -->
            <?php echo $this->render('website/hero'); ?>
            <!-- end hero section -->

            <?php echo $this->render('website/process'); ?>

            <!-- start features -->
            <?php echo $this->render('website/features'); ?>
            <!-- end features -->

            <!-- start services -->
            <?php echo $this->render('website/services'); ?>
            <!-- end services -->

            <!-- start cta -->
            <?php echo $this->render('website/cta'); ?>
            <!-- end cta -->

            <!-- start find jobs -->
            <?php echo $this->render('website/find-jobs'); ?>
            <!-- end find jobs -->


            <!-- start blog -->
            <?php echo $this->render('website/blog'); ?>
            <!-- end blog -->

            <!-- start cta -->
            <?php echo $this->render('website/cta-2'); ?>
            <!-- end cta -->

            <!-- Start footer -->
            <?php echo $this->render('website/footer'); ?>
            <!-- end footer -->


            <!--start back-to-top-->
            <button onclick="topFunction()" class="btn btn-secondary btn-icon landing-back-top" id="back-to-top">
                <i class="ri-arrow-up-line"></i>
            </button>
            <!--end back-to-top-->

        </div>
        <!-- end layout wrapper -->


        <?php echo $this->render('partials/vendor-scripts'); ?>

        <!--Swiper slider js-->
        <script src="/libs/swiper/swiper-bundle.min.js"></script>

        <!--job landing init -->
        <script src="/js/pages/job-lading.init.js"></script>
    </body>

</html>