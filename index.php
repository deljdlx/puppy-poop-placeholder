<?php
//$host = 'http://localhost/__github-deljdlx/puppy-poop-placehoder';
$host = 'http://ppp.jlb.ninja';

require __DIR__ . '/config.php';
$perPage = 100;
$data = json_decode(
    file_get_contents($apiURL . '/media?per_page=' . $perPage),
    true
);

$id = rand(0, count($data) - 1);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>💩 The puppy poop placeholder 💩</title>
        <style>
            main {
                width:1000px;
                margin:auto;
            }
            body {
                font-family: Arial, Helvetica, sans-serif;
            }

            section {
                margin-top: 2rem;
                padding-top: 2rem;
                border-top: solid 4px #CCC;
            }
            figure {
                display: inline-block;
                box-sizing: border-box;
                border: solid 1px #CCC;
                background-color:#EEEE;
                margin: 8px;
            }

            #gallery figure {

            }
            #gallery figure  figcaption {
                padding: 4px 8px;
            }
        </style>
    </head>
    <body>
        
        <main style="">

            <figure style="width:100%; background-color: #CCC;padding:0; margin:0">
                <?php
                $url = $host . '/api.php?width=900&height=400&id=' . $id;
                ?>
                <img src="<?=$url?>" style="width:1000px; height:400px"/>
                <figcaption style="padding: 4px 8px "><a href="<?=$url?>"><?=$url?></a></figcaption>
            </figure>
            <h1>The Puppy Poop Placeholder</h1>


            <section>
                <h2>Usage</h2>
                <code>
                    <pre><?php
                        echo htmlentities('<img src="' . $host . '/api.php?width=500&height=300"/>');
                    ?></pre>
                </code>
                
                <div>
                    <h3>Parameters</h3>
                    <ul>
                        <li>width</li>
                        <li>height</li>
                        <li>offsetLeft</li>
                        <li>offsetTop</li>
                        <li>id</li>
                        <li>autofocus</li>
                    </ul>
                </div>
            </section>


            <section>
                <h2>Focus point</h2>
                <figure>
                    <img src="http://ppp.jlb.ninja/api.php?id=0&width=400&height=200"/>
                    <figcaption>Without focus point</figcaption>
                </figure>

                <figure>
                    <img src="http://ppp.jlb.ninja/api.php?id=0&width=400&height=200&autofocus=1"/>
                    <figcaption>With focus point</figcaption>
                </figure>
            </section>





            <section id="gallery">
                <h2>Gallery</h2>
                <?php
                    $data = array_reverse($data);
                    foreach ($data as $id => $value) {
                        echo '<figure>';
                        echo '<img src="' . $host . '/api.php?id=' . $id . '&width=300&height=200"/>';
                        echo '<figcaption> ID : ' . $id . '</figcaption>';
                        echo '</figure>';
                    }
                ?>
            </section>


            <section id="gallery-random">
                <h2>Random</h2>
                <figure><img src="http://ppp.jlb.ninja/api.php?id=0&width=137&height=200"/><figcaption> ID : 0</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=1&width=469&height=200"/><figcaption> ID : 1</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=2&width=340&height=200"/><figcaption> ID : 2</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=3&width=441&height=200"/><figcaption> ID : 3</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=4&width=523&height=200"/><figcaption> ID : 4</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=5&width=602&height=200"/><figcaption> ID : 5</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=6&width=362&height=200"/><figcaption> ID : 6</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=7&width=282&height=200"/><figcaption> ID : 7</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=8&width=333&height=200"/><figcaption> ID : 8</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=9&width=331&height=200"/><figcaption> ID : 9</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=10&width=271&height=200"/><figcaption> ID : 10</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=11&width=216&height=200"/><figcaption> ID : 11</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=12&width=459&height=200"/><figcaption> ID : 12</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=13&width=369&height=200"/><figcaption> ID : 13</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=14&width=293&height=200"/><figcaption> ID : 14</figcaption></figure><figure><img src="http://ppp.jlb.ninja/api.php?id=15&width=284&height=200"/><figcaption> ID : 15</figcaption></figure>            </section>



            <!--

            <section id="gallery-random">
                <h2>Random</h2>
                <?php
                    /*
                    $data = array_reverse($data);

                    $currentWidth = 0;
                    foreach ($data as $id => $value) {
                        $remaining = 1000 - $currentWidth;
                        if ($remaining <= 600) {
                            $width = $remaining;
                        } else {
                            $width = rand(150, $remaining - 300);
                        }

                        $currentWidth += $width;

                        echo '<figure>';
                        echo '<img src="' . $host . '/api.php?id=' . $id . '&width=' . ($width - 18) . '&height=200"/>';
                        echo '<figcaption> ID : ' . $id . '</figcaption>';
                        echo '</figure>';

                        if ($currentWidth >= 1000) {
                            $currentWidth = 0;
                        }
                    }
                    */
                ?>
            </section>

            //-->


        </main>
    </body>
</html>