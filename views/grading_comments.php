<style>
    .modal {
   position: absolute;
   top: 10px;
   right: 100px;
   bottom: 0;
   left: 0;
   z-index: 10040;
   overflow: auto;
   overflow-y: auto;
}
</style>
<div class="col-md-8 col-lg-10">
                <div class="card">
                    <div class="card-body p-6">
                        <div class="col-md-12">
                            <div class="expanel expanel-secondary">
                                <?php
                                echo '<div class="expanel-heading">
                                        <h3 class="expanel-title">Grading Comments</h3>
                                            </div>
                                            <div class="modal" id="myModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" style="padding-top:20px;" class="comment container">
                                                            <div class="form-outline mb-4">
                                                                <input type="text" id="comment" name="comment" class="form-control" />
                                                                <label class="form-label" for="comment">Comment</label>
                                                            </div>
                                                        
                                                            <div class="form-outline mb-4">
                                                                <textarea type="text" name="description" id="description" class="form-control"></textarea>
                                                                <label class="form-label" for="details">Description</label>
                                                            </div>
                                                            <button type="submit" name="addcomment" class="btn btn-primary">Save</button>
                                                            <button type="button"  class="btn btn-danger" data-dismiss="modal">Close</button>

                                                        </form>        
                                                    </div>
                                                </div>
                                                </div>
                                                
                                            </div>
                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#myModal">
                                                New Comment
                                             </button>
                                            <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="closingimports" class="table table-striped table-bordered" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th class="wd-15p">#</th>
                                                            <th class="wd-15p">Comment</th>
                                                            <th class="wd-20p">Description</th>                                        
                                                        </tr>
                                                    </thead>
                                                    <tbody>';
                                                    $html ="";
                                                    foreach ($comments as $comment){
                                                        $html.='<tr>';
                                                            $html.='<td>'.$comment["id"].'</td>';
                                                            $html.='<td>'.$comment["comment"].'</td>';
                                                            $html.='<td>'.$comment["description"].'</td>';
                                                        $html.='</tr>';
                                                    }
                                            $html.= '</tbody>
                                                </table>
                                            </div>
                                        </div>';
                                        echo $html;
                                ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>