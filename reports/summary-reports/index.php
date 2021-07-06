<?php
$path_to_root = "../../";
include "helpers/common.php";
include $path_to_root . 'templates/header.php';
?>

<body>
    <main class="container">
        <h1 class="mt-5">Examples &amp; Demonstration</h1>
        <p class="lead">
            This demo contains series of examples to guide the usage of KoolReport and its extended packages.
            KoolReport is an intuitive and flexible Open-Source PHP Reporting Framework for faster and easier report delivery. It gives you full control of data process as well as data visualization. It is fast, simple and can be extended in many ways.
        </p>
        <p>
            <i><b>Note:</b> If an example in this demonstration does not work, the reason is that it
            requires either database or extended packages to be installed. You may find all sample databases
            in <code>examples/databases</code> folder, please import them to your database system and change
            connection at <code>config.php</code>.
            If missing package is the issue, you can get them <a href="https://www.koolreport.com/packages">here</a>.
            </i>
        </p>
        <?php
        foreach($menu as $section_name=>$section)
        {
        ?>
            <h4 class="section-header"><?php echo $section_name; ?></h4>
            <div class="row">
                <?php
                foreach($section as $group_name=>$group)
                {
                ?>
                    <div class="col-md-3 example-group col-sm-6">
                        <h5><?php echo (strpos($group_name,"</i>")>0)?$group_name:"<i class='icon-layers'></i>$group_name"; ?></h5>
                        <ul class="list-unstyled">
                        <?php
                        foreach($group as $sname=>$surl)
                        {
                            if(is_string($surl))
                            {
                            ?>
                                <li><a href="<?php echo $root_url.$surl; ?>"><?php echo $sname; ?></a></li>
                            <?php
                            }
                            else
                            {
                            ?>
                                <li>
                                    <strong><i class='fa fa-minus-square-o'></i> <?php echo $sname; ?></strong>
                                    <ul class="list-unstyled">
                                    <?php
                                    foreach($surl as $tname=>$turl)
                                    {
                                    ?>
                                        <li><a href="<?php echo $root_url.$turl; ?>"><?php echo $tname; ?></a></li>
                                    <?php    
                                    }
                                    ?>
                                    </ul>
                                </li>
                            <?php
                            }
                        }
                        ?>
                        </ul>                    
                    </div>
                <?php    
                }
                ?>
            </div>
        <?php    
        }
        ?>
    </main>
    <?php include "helpers/footer.php"; ?>
</body>
</html>