<?php
$path_to_root = "../../";
include $path_to_root . 'templates/header.php';
?>
				<div class="my-3 my-md-5">
					<div class="container-fluid">
						<div class="page-header">
							<h4 class="page-title">Email</h4>
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="#">home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Email</li>
							</ol>
						</div>
						<div class="row">
							<div class="col-lg-3 col-md-12 col-sm-12">
								<div class="card">
									<div class="list-group list-group-transparent mb-0 mail-inbox">
										<div class="mt-3 mb-3 ml-3 mr-3 text-center">
											<a href="#" class="btn btn-success btn-lg btn-block">Compose</a>
										</div>
										<a href="emailservices.html" class="list-group-item list-group-item-action d-flex align-items-center active">
											<span class="icon mr-3"><i class="fe fe-inbox"></i></span>Inbox <span class="ml-auto badge badge-success">14</span>
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-send"></i></span>Sent Mail
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-alert-circle"></i></span>Important <span class="ml-auto badge badge-danger">3</span>
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-star"></i></span>Starred
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-file"></i></span>Drafts
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-tag"></i></span>Tags
										</a>
										<a href="#" class="list-group-item list-group-item-action d-flex align-items-center">
											<span class="icon mr-3"><i class="fe fe-trash-2"></i></span>Trash
										</a>
									</div>
								</div>
								<div class="card">
									<div class="online-status d-flex justify-content-between align-items-center mt-4 mb-2 ml-2">
										<h5 class="chat">Chats</h5>
										<div class="status offline online"> <h6 class="online text-right">online</h6></div>
									</div>
                                    
                                    <!-- CHAT -->
								</div>
							</div>
							<div class="col-lg-9 col-md-12 col-sm-12">
								<div class="card">
									<div class="card-header">
										<h3 class="card-title">Compose new message</h3>
									</div>
									<div class="card-body">
										<form >
											<div class="form-group">
												<div class="row align-items-center">
													<label class="col-sm-2">To</label>
													<div class="col-sm-10">
														<input type="text" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row align-items-center">
													<label class="col-sm-2">Subject</label>
													<div class="col-sm-10">
														<input type="text" class="form-control">
													</div>
												</div>
											</div>
											<div class="form-group">
												<div class="row ">
													<label class="col-sm-2">Message</label>
													<div class="col-sm-10">
														<textarea rows="10" class="form-control"></textarea>
													</div>
												</div>
											</div>
											<div class="btn-list mt-4 text-right">
												<button type="button" class="btn btn-secondary btn-space">Cancel</button>
												<button type="submit" class="btn btn-primary btn-space">Send message</button>
											</div>
										</form>
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