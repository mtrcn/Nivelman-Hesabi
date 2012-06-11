<?php
  for ($i=0;$i < $numPoints+1;$i++) {
     if ($i == 0) {
?>  
    <tr align="center">
      <td><input class="input-mini" type="text" name="id<?php echo $i; ?>"  onblur="getElementById('id_1').value=this.value" value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
      <td></td> <td></td> <td></td>  <td></td> <td></td> <td></td> <td></td> <td></td>  <td></td>
      <td></td>
      <td><input class="input-mini" type="text" name="H<?php echo $i; ?>"  value="<?php echo isset($H[$i])?$H[$i]:null; ?>"></td>
    </tr>
    <tr align="center">
      <td></td>
      <td><input class="input-mini" type="text" name="f_deltah<?php echo $i; ?>"  value="<?php echo isset($f_deltah[$i])?$f_deltah[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="f_l<?php echo $i; ?>"  value="<?php echo isset($f_l[$i])?$f_l[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="b_deltah<?php echo $i; ?>"  value="<?php echo isset($b_deltah[$i])?$b_deltah[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="b_l<?php echo $i; ?>"  value="<?php echo isset($b_l[$i])?$b_l[$i]:null; ?>"></td>
      <td><?php echo isset($fh[$i])?sprintf("%.0f",$fh[$i]):null; ?></td>
      <td><?php echo isset($dhi[$i])?sprintf("%.0f",$dhi[$i]):null; ?></td>
      <td><?php echo isset($m_deltah[$i])?sprintf("%.3f",$m_deltah[$i]):null; ?></td>
      <td><?php echo isset($m_l[$i])?sprintf("%.3f",$m_l[$i]):null; ?></td>
      <td><?php echo isset($vh[$i])?sprintf("%.1f",$vh[$i]*1000):null; ?></td>
      <td><?php echo isset($deltah[$i])?sprintf("%.3f",$deltah[$i]):null; ?></td>
      <td></td>
    </tr>
<?php
    }
    elseif ($i != 0 and ($i + 1) % $numPoints == 1)
   	{
?>
    <tr align="center">
      <td><input class="input-mini" type="text" disabled="disabled" id="id_1"  value="<?php echo isset($id[0])?$id[0]:null; ?>"></td>
      <td></td> <td></td> <td></td>
      <td></td> <td></td> <td></td>
      <td></td> <td></td> <td></td>
      <td></td>
      <td><?php echo isset($H[$i])?sprintf("%.3f",$H[$i]):null; ?></td>
    </tr>
<?php
    }
    else
    {
?> 
    <tr align="center">
      <td><input class="input-mini" type="text" name="id<?php echo $i; ?>"  value="<?php echo isset($id[$i])?$id[$i]:null; ?>"></td>
      <td></td> <td></td> <td></td>  <td></td> <td></td> <td></td> <td></td> <td></td>  <td></td>
      <td></td>
      <td><?php echo isset($H[$i])?sprintf("%.3f",$H[$i]):null; ?></td>
    </tr>
    <tr align="center">
      <td></td>
      <td><input class="input-mini" type="text" name="f_deltah<?php echo $i; ?>"  value="<?php echo isset($f_deltah[$i])?$f_deltah[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="f_l<?php echo $i; ?>"  value="<?php echo isset($f_l[$i])?$f_l[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="b_deltah<?php echo $i; ?>"  value="<?php echo isset($b_deltah[$i])?$b_deltah[$i]:null; ?>"></td>
      <td><input class="input-mini" type="text" name="b_l<?php echo $i; ?>"  value="<?php echo isset($b_l[$i])?$b_l[$i]:null; ?>"></td>
      <td><?php echo isset($fh[$i])?sprintf("%.0f",$fh[$i]):null; ?></td>
      <td><?php echo isset($dhi[$i])?sprintf("%.0f",$dhi[$i]):null; ?></td>
      <td><?php echo isset($m_deltah[$i])?sprintf("%.3f",$m_deltah[$i]):null; ?></td>
      <td><?php echo isset($m_l[$i])?sprintf("%.3f",$m_l[$i]):null; ?></td>
      <td><?php echo isset($vh[$i])?sprintf("%.1f",$vh[$i]*1000):null; ?></td>
      <td><?php echo isset($deltah[$i])?sprintf("%.3f",$deltah[$i]):null; ?></td>
      <td></td>
    </tr>
<?php
    }
}
if (!$isEmpty) {
?>
  <tr align="center">
    <th>Toplam:</th>
    <td><?php echo isset($f_deltah)?sprintf("%.3f",array_sum($f_deltah)):null; ?></td>
    <td><?php echo isset($f_l)?sprintf("%.3f",array_sum($f_l)):null; ?></td>
    <td><?php echo isset($b_deltah)?sprintf("%.3f",array_sum($b_deltah)):null; ?></td>
    <td><?php echo isset($b_l)?sprintf("%.3f",array_sum($b_l)):null; ?></td>
    <td><?php echo isset($fh)?sprintf("%.0f",array_sum($fh)):null; ?></td>
    <td></td>
    <td><?php echo isset($m_deltah)?sprintf("%.1f mm",array_sum($m_deltah)*1000):null; ?></td>
    <td><?php echo isset($m_l)?sprintf("%.3f",array_sum($m_l)):null; ?></td>
    <td><?php echo isset($vh)?sprintf("%.1f mm",array_sum($vh)*1000):null; ?></td>
    <td></td><td></td>
  </tr>
      <?
  }