<!--
some html knowledges required ...
if not .... google is your best  friend..->html tags

http://www.w3schools.com/tags/

-->

<h2>Details first name</h2>
<div class="plugin-attributes box">
<div class="row _200">
        <?php
//		first we check  to see if session is not empty..
//                  on  submit may be errors        
//                  before submit we take data into  a variable  a function in index.php does that..
//                   if errors  there is data... it's time to get it back'     
            if( Session::newInstance()->_getForm('pplugin_first_name') != "" ) {
                $detail['s_plugin1_first_name'] = Session::newInstance()->_getForm('pplugin_first_name');
            }
        ?>
    <!--                label for is not mandatory ...
                can be used  as your needs
                try delete it.. see action in item file
                can be ->
<p class="my_class">First name -</p>
and style  from css file
can be used to style  each one   or as a group all having same  for = "plugin_1" ..

-->
        <label for="first_name">First Name  </label>
        
<!--       name is MANDATORY
       name="plugin_first_name"
       must be uniq in this plugin and all other plugins...
       inspect page not to have  2 name atrributes  same
each new input field added must have unique name
name="plugin_second_name"
name="can_be_whatever_name"
FOR A BETTER TRACKING OF THE CODE  IS  BETTER TO KEEP NAME  RELATED  WITH DETAIL VARIABLE
name="plugin_first_name" value=" ..... echo @$detail['s_plugin1_first_name']
-->
       
        
        <input type="text" name="plugin_first_name" value="<?php echo @$detail['s_plugin1_first_name']; ?>" />
    </div>
 </div>
 