<?php
class database
{
	var $db;
	function __construct(){
		$this->db= new mysqli();
	}//end function core(...
	/*-----------------------------------------------------------------*/
	function connect($dblocation,$dbuser,$dbpass,$dbname){
		$this->db->connect($dblocation,$dbuser,$dbpass,$dbname);

		if ($this->db->connect_errno){
			echo "Could not connect. MySQL: " . mysqli_connect_error();
			return false;
		}
		$this->db->set_charset('utf8');
		return true;
	}//end function core(...
	/*-----------------------------------------------------------------*/
	function query($query){
		$result= $this->db->query($query) or die($this->db->error);
		return $result;
	}//end function query(...
	/*-----------------------------------------------------------------*/
	function fetch_array(mysqli_result $result){
		$result= mysqli_fetch_array($result);
		return $result;
	}//end function query(...
	/*-----------------------------------------------------------------*/
	function fetch_row(mysqli_result $result){
		$result= mysqli_fetch_row($result);
		return $result;
	}//end function query(...
	/*-----------------------------------------------------------------*/
	function result(mysqli_result $result,$field_name,$row=0){
		mysqli_data_seek($result,$row);
		return $result->fetch_array()[$field_name];
	}//end function result(...
	/*-----------------------------------------------------------------*/
	function inserted_id($result=''){
		return $this->db->insert_id;
	}//end function result(...
	/*-----------------------------------------------------------------*/
	function insert_id($result=''){
		return $this->db->insert_id;
	}//end function result(...
	/*-----------------------------------------------------------------*/
	function num_rows(mysqli_result $result){
		return $result->num_rows;
	}//end function result(...
	/*-----------------------------------------------------------------*/
	function element_select($query,$name,$field_value,$field_text,$old_value,$first_option,$other_fields="",$style='',$hidden=0,$attr=''){
		if($style){
			$style="style='$style'";
		}
		if($hidden){
			$style="style='display:none;'";
		}
		$result_html="<select name='$name' $style $attr>";
		if($first_option){$result_html.="<option value='' >$first_option</option>";;}
		$result=$this->query($query);
		while($row=$this->fetch_array($result)){
			if($old_value==$row[$field_value]){$selected='selected="selected"';}else{$selected="";}
			$other_fields_to_show='';
			if($other_fields!=""){
				foreach($other_fields as $key=>$val){
					$other_fields_to_show.=$row[$val].' ';
				}//end foreach ...
			}
			$result_html.="<option value='".$row[$field_value]."' $selected>".$row[$field_text].' '.$other_fields_to_show."</option>";
		}//end while($row=$this->fetch_array($result))...
		$result_html.="</select>";

		return $result_html;
	}//end function element_select(...
	/*-----------------------------------------------------------------*/
	function element_checkbox_array($query,$name,$field_value,$field_text,$old_value,$other_fields="",$class='',$style='',$attr=''){
		if($style){
			$style="style='$style'";
		}
		if($class){
			$class="class='$class'";
		}
		$result_html='';
		$result=$this->query($query);
		while($row=$this->fetch_array($result)){
			if($old_value[$field_value]==$row[$field_value]){$checked='checked';}else{$checked='';}
			$other_fields_to_show='';
			if($other_fields!=""){
				foreach($other_fields as $key=>$val){
					$other_fields_to_show.=$row[$val].' ';
				}//end foreach ...
			}
			$result_html.="
				<label for='checkbox_{$name}_{$row[$field_value]}'>
					{$row[$field_text]} $other_fields_to_show
				</label>
				<input type='checkbox' $checked name='{$name}[{$row[$field_value]}]' 
				data-id='{$row[$field_value]}' id='checkbox_{$name}_{$row[$field_value]}'
				$class $attr >  
			";
		}//end while($row=$this->fetch_array($result))...

		return $result_html;
	}//end function ...
	/*-----------------------------------------------------------------*/
	function element_radio($query,$name,$field_value,$field_text,$old_value,$other_fields="",$class='',$style='',$attr=''){
		if($style){
			$style="style='$style'";
		}
		if($class){
			$class="class='$class'";
		}
		$result_html='';
		$result=$this->query($query);
		while($row=$this->fetch_array($result)){
			if($old_value==$row[$field_value]){$checked='checked';}else{$checked='';}
			$other_fields_to_show='';
			if($other_fields!=""){
				foreach($other_fields as $key=>$val){
					$other_fields_to_show.=$row[$val].' ';
				}//end foreach ...
			}
			$attr_=str_replace('row[field_value]', $row[$field_value], $attr);
			$result_html.="
				<label for='checkbox_{$name}_{$row[$field_value]}'>
					{$row[$field_text]} $other_fields_to_show
				</label>
				<input type='radio' $checked name='{$name}' value='{$row[$field_value]}' 
				data-id='{$row[$field_value]}' id='checkbox_{$name}_{$row[$field_value]}'
				$class $attr_ >  
			";
		}//end while($row=$this->fetch_array($result))...

		return $result_html;
	}//end function ...
	/*-----------------------------------------------------------------*/
}//end class
?>