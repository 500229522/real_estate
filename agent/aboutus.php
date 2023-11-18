<div class="card card-outline rounded-0 card-primary">
    <div class="card-header">
        <h3 class="card-title">THE LOCAL BUSINESS WITH A GLOBAL BRAND</h3>
    </div>

    <div class="card-body">
        <p>We are certain that we can help you, whether your goal is to purchase, sell, or find a place to further your real estate career. </p>
        <p>Please call us. We'd be delighted to assist you!</p>
        
        <div class="container">
            <?php 
                $files = array();
                $fopen = scandir(base_app.'uploads/aboutus/agent');
                foreach($fopen as $fname){
                    if(in_array($fname,array('.','..')))
                    continue;
                    $files[]= validate_image('uploads/aboutus/agent/'.$fname);
                }
            ?>
            <div id="tourCarousel"  class="carousel slide" data-ride="carousel" data-interval="3000">
                <div class="carousel-inner h-100">
                    <?php foreach($files as $k => $img): ?>
                    <div class="carousel-item  h-100 <?php echo $k == 0? 'active': '' ?>">
                        <img class="d-block w-100  h-100" style="object-fit:contain" src="<?php echo $img ?>" alt="">
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>