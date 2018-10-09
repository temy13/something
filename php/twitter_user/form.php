<input type="hidden" name="twitter_user_record_id" value="<?php echo $tw_row['id']; ?>">

<div class="form-group">
  <label>Consumer Key</label>
  <input type = "text" name ="consumer_key" class="form-control" placeholder="Consumer Key" value="<?php echo $tw_row['consumer_key'] ?>">
</div>

<div class="form-group">
  <label>Consumer Secret</label>
  <input type = "text" name ="consumer_secret" class="form-control" placeholder="Consumer Secret" value="<?php echo $tw_row['consumer_secret'] ?>">
</div>

<div class="form-group">
  <label>Access Token</label>
  <input type = "text" name ="access_token" class="form-control" placeholder="Access Token" value="<?php echo $tw_row['access_token'] ?>">
</div>

<div class="form-group">
  <label>Access Token Secret</label>
  <input type = "text" name ="access_token_secret" class="form-control" placeholder="Access Token Secret" value="<?php echo $tw_row['access_token_secret'] ?>">
</div>
