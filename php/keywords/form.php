<input type="hidden" name="twitter_user_id" value="<?php echo $twitter_user_id; ?>">
<div class="form-group">
  <label>指定するキーワード</label>
  <input type = "text" name ="keyword" class="form-control" placeholder="キーワード" value="<?php echo $row['keyword'] ?>">
</div>
<div class="form-group">
  <label>RTするツイートの数</label>
  <input type = "number" name ="count" class="form-control" max=10 min = 1 value="<?php echo ($row['count'] ? $row['count'] : 1) ?>">
</div>
<div class="form-group">
  <label>タイミング</label>
  <label class="radio-inline"><input type="radio" name="timing_type" value="auto" class="timing-form-btn" id="timing-type-btn-auto" <?php echo $row["timing_type"] != "manual" ? "checked" : "" ?> onChange="timeSet('auto')">数分おき</label>
  <label class="radio-inline"><input type="radio" name="timing_type" value="manual" class="timing-form-btn" id="timing-type-btn-manual"  <?php echo $row["timing_type"] == "manual" ? "checked" : "" ?> onChange="timeSet('manual')">時間指定</label>
</div>
<div class="form-group timing-auto timing-set">
  <input type = "time" name ="interval_time" class="" value="<?php echo $row['interval_time'] ?>">分おきにRT
</div>
<div class="form-group timing-manual timing-set">
  <?php for ($i=0; $i<4; $i++) { ?>
    <div><input type = "time" name="manual_time[]" class="" value="<?php echo $row['manual_time_'.($i)] ?>">にRT</div>
  <?php } ?>
  <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="false" aria-controls="collapseExample">
    もっと指定する
  </button>
  <div class="collapse" id="collapse1">
    <?php for ($i=4; $i<14; $i++) { ?>
      <div><input type = "time" name="manual_time[]" class="" value="<?php echo $row['manual_time_'.($i)] ?>" >にRT</div>
    <?php } ?>
    <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapseExample">
      もっと指定する
    </button>
    <div class="collapse" id="collapse2">
      <?php for ($i=14; $i<24; $i++) { ?>
        <div><input type = "time" name="manual_time[]" class="" value="<?php echo $row['manual_time_'.($i)] ?>">にRT</div>
      <?php } ?>
    </div>
  </div>
</div>
