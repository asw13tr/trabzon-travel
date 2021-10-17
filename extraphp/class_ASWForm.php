<?php class ASWForm{

	function open($action=null, $method="POST", $upload=false, $class=null, $extra=null){
		$enctype = !$upload? null : ' enctype="multipart/form-data"';
		$class = !$class? null : ' '.$class;
		return '<form action="'.$action.'" method="'.$method.'" class="form-horizontal'.$class.'"'.$enctype.'>';
	}



	function close(){
		return '</form>';
	}

	function input($type="text", $id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
		    <div class=\"col-sm-10\"><input type=\"{$type}\" class=\"form-control\" name=\"{$id}\" id=\"{$id}\" value=\"{$value}\"{$extrain}>{$description}</div>
		  </div>";
	}

	function text($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		return $this->input('text', $id, $title, $value, $desc, $extrain, $extraout);
	}

	function mail($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		return $this->input('email', $id, $title, $value, $desc, $extrain, $extraout);
	}

	function password($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		return $this->input('password', $id, $title, $value, $desc, $extrain, $extraout);
	}

	function tel($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		return $this->input('tel', $id, $title, $value, $desc, $extrain, $extraout);
	}

	function hidden($id=null, $value=null){
		return '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$value.'">';
	}


	function textarea($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
		    <div class=\"col-sm-10\"><textarea class=\"form-control\" rows=\"5\" name=\"{$id}\" id=\"{$id}\"{$extrain}>{$value}</textarea>{$description}</div>
		  </div>";
	}

	function ckeditor($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
		    <div class=\"col-sm-10\"><textarea class=\"ckeditor\" name=\"{$id}\" id=\"{$id}\"{$extrain}>{$value}</textarea>{$description}</div>
		  </div>";
	}

	function file($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$valueContent=null;


			$valueContent = "<div class=\"col-sm-2\"></div>
			<div class=\"col-sm-10\" style=\"{$valueContentStyle}\" id=\"{$id}_div\">
			<input type=\"hidden\" name=\"{$id}_hide\" id=\"{$id}_hide\" value=\"{$value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_xs\" id=\"{$id}_hide_xs\" value=\"{$value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_md\" id=\"{$id}_hide_md\" value=\"{$value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_lg\" id=\"{$id}_hide_lg\" value=\"{$value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_json\" id=\"{$id}_hide_json\" value=\"{$value}\"/>
			<a href=\"".URL_UPLOAD_IMAGES."{$img_value}\" data-fancybox=\"content-cover-photo\">
			<img src=\"".URL_UPLOAD_IMAGES."{$img_value}\" class=\"img-responsive inputHiddenImg\" id=\"{$id}_img\"/>
			</a>
			<a style='{$valueContentStyle} color:red; text-decoration:underline; cursor:pointer;' name='{$id}' class='removeImageLink'>Resmi Kaldır</a>
			</div>
			<div class=\"clearfix\"></div>";

		return "<div class=\"form-group\"{$extraout}>{$valueContent}
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
		    <div class=\"col-sm-10\"><input type=\"file\" name=\"{$id}\" class=\"form-control inputUploadFile\" id=\"{$id}\" value=\"{$value}\"{$extrain}>{$description}</div>
		  </div>";
	}


	function radio($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
			<div class=\"col-sm-10\">";

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = $value==$key? ' checked' : null;
				$result .= "<label class=\"radio-inline\"><input type=\"radio\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}


	function checkboxes($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
			<div class=\"col-sm-10\">";

		if(!is_array($value)){
			$value = array($value);
		}

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = in_array($key, $value)? ' checked' : null;
				$result .= "<label class=\"checkbox-inline\" ><input type=\"checkbox\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}

	function checkboxlist($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
			<div class=\"col-sm-10\" style=\"max-height:140px; overflow;hidden; overflow-y:auto;\">";

		if(!is_array($value)){
			$value = array($value);
		}

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = in_array($key, $value)? ' checked' : null;
				$result .= "<div class=\"checkbox\"><label><input type=\"checkbox\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label></div>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}






	function select($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
			<div class=\"col-sm-10\">";

		if($values && is_array($values)){
			$counter = 0;
			$result .= "<select name=\"{$id}\" id=\"{($id.$counter)}\" class=\"form-control\"{$extrain}>";
			foreach($values as $key => $val){ $counter++;
				$selected = $value==$key? ' selected' : null;
				$result .= "<option value=\"{$key}\"{$selected}>{$val}</option>";
			}
			$result .= "</select>";
		}

		$result .= "</div></div>";
		return $result;
	}

	function selectez($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\" class=\"col-sm-2 control-label\">{$title}</label>
			<div class=\"col-sm-10\">";

		if($values && is_array($values)){
			$counter = 0;
			$result .= "<select name=\"{$id}\" id=\"{($id.$counter)}\" class=\"form-control\"{$extrain}>";
			foreach($values as $key => $val){ $counter++;
				$selected = $value==$key? ' selected' : null;
				$result .= "<option value=\"{$val}\"{$selected}>{$val}</option>";
			}
			$result .= "</select>";
		}

		$result .= "</div></div>";
		return $result;
	}



	function save($title="Kaydet"){
		echo '<div class="form-group">
			    <div class="col-sm-offset-2 col-sm-10">
			      <button type="submit" class="btn btn-default btn-primary">'.$title.'</button>
			    </div>
			  </div>';
	}













	/*
		###############################################################################
		###############################################################################
		###############################################################################
		DİKEY FORM ELEMANLARI İÇİN OLAN FONKSİYONLAR.
		FONKSİYON İSİMLERİNİN BAŞINA "v_" EKLENİR.
		###############################################################################
		###############################################################################
		###############################################################################
	*/

	function v_open($action=null, $method="POST", $upload=false, $class=null, $extra=null){
		$enctype = !$upload? null : ' enctype="multipart/form-data"';
		$class = !$class? null : ' '.$class;
		return '<form action="'.$action.'" method="'.$method.'" class="'.$class.'"'.$enctype.' '.$extra.'>';
	}



	function v_close(){
		return '</form>';
	}

	function v_input($type="text", $id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
		    <input type=\"{$type}\" class=\"form-control\" name=\"{$id}\" id=\"{$id}\" value=\"{$value}\"{$extrain}>{$description}{$content}
		  </div>";
	}

	function v_text($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		return $this->v_input('text', $id, $title, $value, $desc, $extrain, $extraout, $content);
	}

	function v_mail($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		return $this->v_input('email', $id, $title, $value, $desc, $extrain, $extraout, $content);
	}

	function v_password($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		return $this->v_input('password', $id, $title, $value, $desc, $extrain, $extraout, $content);
	}

	function v_tel($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		return $this->v_input('tel', $id, $title, $value, $desc, $extrain, $extraout, $content);
	}

	function v_url($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		return $this->v_input('url', $id, $title, $value, $desc, $extrain, $extraout, $content);
	}

	function v_hidden($id=null, $value=null){
		return '<input type="hidden" id="'.$id.'" name="'.$id.'" value="'.$value.'">';
	}


	function v_textarea($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
		    <textarea class=\"form-control\" rows=\"5\" name=\"{$id}\" id=\"{$id}\"{$extrain}>{$value}</textarea>{$description}{$content}
		  </div>";
	}

	function v_ckeditor($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		return "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
		    <textarea class=\"ckeditor\" name=\"{$id}\" id=\"{$id}\"{$extrain}>{$value}</textarea>{$description}
		  </div>";
	}

	function v_file($id=null, $title=null, $value=null, $desc=null, $extrain=null, $extraout=null, $content=null, $required=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$valueContent=null;

		$valueContentStyle = !$value? 'display:none;' : 'display:block;';

		$values = !$value? null : json_decode($value) ;
		$img_value = isset($values->img)? $values->img : null;
		$xs_value = isset($values->xs)?  $values->xs : null;
		$md_value = isset($values->md)?  $values->md : null;
		$lg_value = isset($values->lg)?  $values->lg : null;
			$valueContent = "
			<label for=\"{$id}\">{$title}</label>
			<div style=\"{$valueContentStyle}\" id=\"{$id}_div\">
			<input type=\"hidden\" name=\"{$id}_hide\" id=\"{$id}_hide\" value=\"{$img_value}\" {$required}/>
			<input type=\"hidden\" name=\"{$id}_hide_xs\" id=\"{$id}_hide_xs\" value=\"{$xs_value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_md\" id=\"{$id}_hide_md\" value=\"{$md_value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_lg\" id=\"{$id}_hide_lg\" value=\"{$lg_value}\"/>
			<input type=\"hidden\" name=\"{$id}_hide_json\" id=\"{$id}_hide_json\" value=\"{$value}\"/>
			<a href=\"".URL_UPLOAD_IMAGES."{$img_value}\" data-fancybox=\"content-cover-photo\">
			<img src=\"".URL_UPLOAD_IMAGES."{$img_value}\" class=\"img-responsive inputHiddenImg\" id=\"{$id}_img\"/>
			</a>
			<a style='{$valueContentStyle} color:red; text-decoration:underline; cursor:pointer;' name='{$id}' class='removeImageLink'>Resmi Kaldır</a>
			</div>
			<div class=\"clearfix\"></div>";

		return "<div class=\"form-group\"{$extraout}>{$valueContent}
		    <div class=\"col-xs-9 col-sm-10\" style=\"padding-left:0px;\">
				<input type=\"file\" name=\"{$id}\" class=\"form-control inputUploadFile\" name=\"upload_file_{$id}\" id=\"upload_file_{$id}\" value=\"{$value}\"{$extrain}>
			</div>
			<div class=\"col-xs-3 col-sm-2\" style=\"padding:0px;\"><span class=\"btn btn-primary form-control doUploadButton\" id=\"{$id}\">Yükle</span></div>
			<div class=\"clearfix\"></div>
			<div class=\"colx-xs-12\">{$description}{$content}</div>
		  </div>";
	}


	function v_radio($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
			<div>";

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = $value==$key? ' checked' : null;
				$result .= "<label class=\"radio-inline\"><input type=\"radio\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}


	function v_checkboxes($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
			<div>";

		if(!is_array($value)){
			$value = array($value);
		}

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = in_array($key, $value)? ' checked' : null;
				$result .= "<label class=\"checkbox-inline\" ><input type=\"checkbox\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}

	function v_checkboxlist($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
			<div style=\"max-height:140px; overflow;hidden; overflow-y:auto;\">";

		if(!is_array($value)){
			$value = array($value);
		}

		if($values && is_array($values)){
			$counter = 0;
			foreach($values as $key => $val){ $counter++;
				$checked = in_array($key, $value)? ' checked' : null;
				$result .= "<div class=\"checkbox\"><label><input type=\"checkbox\" name=\"{$id}\" id=\"{($id.$counter)}\" value=\"{$key}\"{$checked}> {$val}</label></div>";
			}
		}

		$result .= "</div></div>";
		return $result;
	}






	function v_select($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
			<div>";

		if($values && is_array($values)){
			$counter = 0;
			$result .= "<select name=\"{$id}\" id=\"{$id}_select\" class=\"form-control\"{$extrain}>";
			foreach($values as $key => $val){ $counter++;
				$selected = $value==$key? ' selected' : null;
				$option_id = $id.$key;
				$result .= "<option id=\"{$option_id}\" value=\"{$key}\"{$selected}>{$val}</option>";
			}
			$result .= "</select>{$content}";
		}

		$result .= "</div></div>";
		return $result;
	}

	function v_selectez($id=null, $title=null, $value=null, $values=null, $desc=null, $extrain=null, $extraout=null, $content=null){
		$extrain = !$extrain? null : ' '.$extrain;
		$extraout = !$extraout? null : ' '.$extraout;
		$description = !$desc? null : "<small>{$desc}</small>";
		$result = "<div class=\"form-group\"{$extraout}>
		    <label for=\"{$id}\">{$title}</label>
			<div>";

		if($values && is_array($values)){
			$counter = 0;
			$slctid = $id.$counter;
			$result .= "<select name=\"{$id}\" id=\"{$id}\" class=\"form-control\"{$extrain}>";
			foreach($values as $key => $val){ $counter++;
				$selected = $value==$val? ' selected' : null;
				$opt_id = $id.'_'.$val;
				$result .= "<option value=\"{$val}\" id=\"{$opt_id}\"{$selected}>{$val}</option>";
			}
			$result .= "</select>{$content}";
		}

		$result .= "</div></div>";
		return $result;
	}



	function v_save($title="Kaydet"){
		echo '<div class="form-group">
			    <div>
			      <button type="submit" class="btn btn-default btn-primary">'.$title.'</button>
			    </div>
			  </div>';
	}

} ?>
