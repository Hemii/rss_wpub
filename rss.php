<!doctype html>
<html lang="sk">
<head>
    <!-- Required meta tags -->
    <!-- <meta charset="utf-8"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <!-- Fonts Merriweather and Open Sans -->
    <link href="https://fonts.googleapis.com/css?family=Merriweather|Open+Sans" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <title>RSS_reader!</title>

    <!-- We use Merriweather font for headings and Open Sans fonts for other text - THEY ARE LINKED -->
</head>
<?php
class clanok
{
    public $title;
    public $date;
    public $sort;
    public $link;
    public $description;
    public $picture_url;
}
function cmp_n_o($a, $b)
{
    return strcmp($b->sort, $a->sort);
}

function cmp_o_n($a, $b)
{
    return strcmp($a->sort, $b->sort);
}
?>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
            <label class="navbar-brand " style="color: grey">RSS</label>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse " id="navbarSupportedContent">
                <form class="form-inline mx-auto" style="width:100%;" method="post">
                    <ul class="navbar-nav w-100">
                        <li class="nav-item w-100 w-lg-55 my-2 my-lg-0 d-flex justify-content-end" style="max-height: 42px;">
                            <input name="feedurl" type="text" class="form-control my-2 my-sm-0" placeholder="URL" class="">&nbsp;
                            <select name="taskOption" class="my-2 my-sm-0 btn btn-dark dropdown-toggle">
                                <option value="1">Asc</option>
                                <option value="2">Desc</option>
                            </select>
                        </li>
                        <li class="nav-item ml-auto">
                            <!-- <button class="btn my-2 my-sm-0 ml-auto" style="color: grey" type="sort" value="sort" name="sort">Sort</button> -->
                            <button class="btn my-2 my-sm-0 ml-auto" style="color: grey" value="znova" name="znova">Reload / Fetch</button>
                        </li>
                    </ul>
                </form>
            </div>
        </nav>
    </header>
    <main>
        <?php
        $clanky = array();
        //https://www.ta3.com/rss/3/novinky-z-domova.html
        $url = "https://www.sme.sk/rss-title";
        if (isset($_POST['znova'])) {
            if ($_POST['feedurl'] != '') {
                $url = $_POST['feedurl'];
                $clanky = array();
            }
        }
        $feeds = simplexml_load_file($url);
        ?>

        <?php
        foreach ($feeds->channel->item as $item) {
            $temp = new clanok;
            $temp->title = $item->title;
            $temp->link = $item->link;
            $temp->date = $item->pubDate;
            $temp->sort = strtotime($item->pubDate);
            $temp->picture_url =  $item->enclosure['url'];
            $temp->description = $item->description;

            array_push($clanky, $temp);
        }
        if (isset($_POST['znova'])) {
            if ($_POST['taskOption'] == 2) {
                usort($clanky, "cmp_o_n");
            } else {
                usort($clanky, "cmp_n_o");
            }
        }
        ?>
        <div class="container row mx-auto">
            <div class=" col-md-4 col-12">
                <?php
                foreach ($clanky as $item) {
                    ?>
                    <div class="row">
                        <div class="card col-12">
                            <div class="card-body">
                                <a href="<?php echo $item->link ?>" class="btn"><?php echo $item->date ?>,<?php echo "<br>" ?> <?php echo $item->title ?></a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class=" col-md-8 col-12">
                <?php
                $feeds = simplexml_load_file($url);
                foreach ($clanky as $item) {
                    ?>
                    <div class="card">
                        <img class="card-img-top" src=" <?php echo $item->picture_url ?>" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $item->title ?></h5>
                                <p><?php echo $item->date ?></p>
                                <p class="card-text"><?php echo $item->description ?></p>
                                <a href="<?php echo $item->link ?>" class="btn">Viac TU!</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>

    </main>


    <footer>


    </footer>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>