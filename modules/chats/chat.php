<?php
$path_to_root = "../../";
include $path_to_root . 'templates/header.php';
?>
<div class="my-3 my-md-5">
    <div class="container">
        <div class="page-header">
            <h4 class="page-title">Chat</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">UI Design</a></li>
                <li class="breadcrumb-item active" aria-current="page">chat</li>
            </ol>
            <button type="button" class="btn btn-outline-primary"><i class="fa fa-pencil mr-2"></i>Edit Page</button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-6">
                        <div id="demo">
                            <div class="vertical-align">
                                <div class="container p-0">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="no-border">
                                                <div id="chat" class="conv-form-wrapper">
                                                    <form method="GET" class="hidden">
                                                        <select data-conv-question="Hello! I'm a Viboon created from a HTML form. Can I show you some features? (this question comes from a select)" name="first-question">
                                                            <option value="yes">Yes</option>
                                                            <option value="sure">Sure!</option>
                                                        </select>
                                                        <input type="text" name="name" data-conv-question="Alright! First, tell me your full name, please.|Okay! Please, tell me your name first.">
                                                        <input type="text" data-conv-question="Howdy, {name}:0! It's a pleasure to meet you. (note that this question doesn't expect any answer)" data-no-answer="true">
                                                        <input type="text" data-conv-question="This plugin supports multi-select too. Let's see an example." data-no-answer="true">
                                                        <select name="multi[]" data-conv-question="What kind of music do you like?" multiple>
                                                            <option value="Rock">Rock</option>
                                                            <option value="Pop">Pop</option>
                                                            <option value="Country">Country</option>
                                                            <option value="Classic">Classic</option>
                                                        </select>
                                                        <select name="programmer" data-callback="storeState" data-conv-question="So, are you a programmer? (this question will fork the conversation based on your answer)">
                                                            <option value="yes">Yes</option>
                                                            <option value="no">No</option>
                                                        </select>
                                                        <div data-conv-fork="programmer">
                                                            <div data-conv-case="yes">
                                                                <input type="text" data-conv-question="A fellow programmer! Cool." data-no-answer="true">
                                                            </div>
                                                            <div data-conv-case="no">
                                                                <select name="thought" data-conv-question="Have you ever thought about learning? Programming is fun!">
                                                                    <option value="yes">Yes</option>
                                                                    <option value="no">No..</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <input type="text" data-conv-question="convForm also supports regex patterns. Look:" data-no-answer="true">
                                                        <input data-conv-question="Type in your e-mail" data-pattern="^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$" id="email" type="email" name="email" required placeholder="What's your e-mail?">
                                                        <input data-conv-question="Now tell me a secret (like a password)" type="password" data-minlength="6" id="senha" name="password" required placeholder="password">
                                                        <select data-conv-question="Selects also support callback functions. For example, try one of these:">
                                                            <option value="google" data-callback="google">Google</option>
                                                            <option value="bing" data-callback="bing">Bing</option>
                                                        </select>
                                                        <select name="callbackTest" data-conv-question="You can do some cool things with callback functions. Want to rollback to the 'programmer' question before?">
                                                            <option value="yes" data-callback="rollback">Yes</option>
                                                            <option value="no" data-callback="restore">No</option>
                                                        </select>
                                                        <select data-conv-question="This is it! If you like me, consider donating! If you need support, contact me. When the form gets to the end, the plugin submits it normally, like you had filled it.">
                                                            <option value="">Awesome!</option>
                                                        </select>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<a href="#top" id="back-to-top" style="display: inline;"><i class="fa fa-angle-up"></i></a>

<script src='../../assets/plugins/fullcalendar/moment.min.js'></script>
<script src='../../assets/js/vendors/jquery-3.2.1.min.js'></script>
<script src="../../assets/js/vendors/bootstrap.bundle.min.js"></script>
<script src="../../assets/js/vendors/jquery.sparkline.min.js"></script>
<script src="../../assets/js/vendors/selectize.min.js"></script>
<script src="../../assets/js/vendors/jquery.tablesorter.min.js"></script>
<script src="../../assets/js/vendors/circle-progress.min.js"></script>
<script src="../../assets/plugins/rating/jquery.rating-stars.js"></script>
<script src='../../assets/plugins/fullcalendar/fullcalendar.min.js'></script>

<!-- Custom scroll bar Js-->
<script src="../../assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>

<!-- Custom JS-->
<script src="../../assets/js/fullcalendar.js"></script>
<script src="../../assets/js/custom.js"></script>