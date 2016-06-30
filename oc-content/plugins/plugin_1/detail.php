<!--
some html knowledges required ...
if not .... google is your best  friend..->html tags

http://www.w3schools.com/tags/

-->


<h2>Details First Name </h2>

    <table>
         <?php
         
         /// check to see  is empty 
         // if not empty  display  it
         
         if(@$detail['s_plugin1_first_name'] != '') { ?>
        <tr>
            <td>
<!--                label for is not mandatory ...
                can be used  as your needs
                try delete it.. see action in item file
                can be ->
<p class="my_class">First name -</p>
and style  from css file
can be used to style  each one   or as a group all having same  for = "plugin_1" ..

-->
                <label for="first_name">First name -</label>
                
            </td>
            <td><?php echo @$detail['s_plugin1_first_name']; ?></td>
        </tr>
        <?php  } ?>
</table>
    

