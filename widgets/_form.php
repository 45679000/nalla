<?php
  
class Form{
    public $textField;
    public $checkBox;
    public $textArea;
    public $dropDownList;
    public $formMessage;
    public $messageType;

     public function beginForm(){
        print '<form method="post" class="card">';
     }
     public function endForm(){
        print '</form>';
     }
     public function formField($fieldType, $name, $placeholder = "", $lableName, $dataSourse = [], $fieldvalue=""){
        if($fieldType=="text"){
         print '<div class="form-group">';
         print '<label class="form-label">'.$lableName.'</label>';
         print '<input type="'.$fieldType.'" class="form-control" name="'.$name.'" value="'.$fieldvalue.'">';
         print '</div>';
        }
        if($fieldType=="text-area"){
         print '<div class="form-group">';
         print '<label class="form-label">'.$lableName.'</label>';
         print '<textarea  type="'.$fieldType.'" class="form-control" rows="4" cols="5" name="'.$name.'" value="'.$fieldvalue.'"></textarea>';
         print '</div>';
        }
         if($fieldType=="dropdownlist"){
         print '<div class="form-group">';
         print '<label class="form-label">'.$lableName.'</label>';
         print '<select name = '.$name.' class="form-control  select2-show-search" data-placeholder="Select)">';
         print '<label class="form-label"> Select2 with search box</label>';
         foreach($dataSourse as $key => $value){
          print '<option value="'.$key.'">'.$value.'</option>';
         }
       
         print '</select>
         </div>';

        }
     }
     public function addButtons($name="save"){
      print '<div class="text-wrap mt-6">
               <div class="example">
                  <div class="btn-list text-center">
                     <button type="submit" name='.$name.' class="btn btn-success">Save changes</button>
                  </div>
               </div>
            </div>';

     }
     public function formMessage(){
        print '<div class="row">';
        if($this->messageType=="success"){
         print '<div class="col-sm-12 col-md-12">
            <div class="alert alert-success">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <hr class="message-inner-separator">
               <p>'.$this->formMessage.'</p>
            </div>
         </div>';
         if($this->messageType=="error"){
            print '<div class="col-sm-12 col-md-6">
            <div class="alert alert-danger">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <strong>Success Message</strong>
               <hr class="message-inner-separator">
               <p>'.$this->formMessage.'</p>
            </div>
         </div>';
         }
         print '</div>';

         
        }

     }
     
 }
 
 ?>