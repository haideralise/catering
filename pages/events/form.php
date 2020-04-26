<?php

include_once '../../bootstrap.php';

$id = null;
$name = '';
$details = '';
$message = '';
$error = false;
$errors = [];
$categories = Event::get();
try{
    if(isset($_GET['id']) || isset($_POST['record_id'])) {
        $id = isset($_POST['record_id']) ? $_POST['record_id'] : $_GET['id'];
        $Event = Event::findOrFail($id);
    }else {
        $Event = new Event();
    }

    if(@$_POST['save']) {

        if(
                !empty($_POST['name'])
                && !empty($_POST['number_of_people'])
                && !empty($_POST['number_of_waiters'])
                && !empty($_POST['separate_male_female'])
                && !empty($_POST['starts_at'])
                && !empty($_POST['hours'])
                && !empty($_POST['status'])
                && !empty($_POST['user_id'])
        ) {
            // update
            $gathering_type = $_POST['gathering_type'];
            $number_of_people = $_POST['number_of_people'];
            $number_of_waiters = $_POST['number_of_waiters'];
            $separate_male_female = $_POST['separate_male_female'];
            $starts_at = $_POST['starts_at'];
            $status = $_POST['status'];
            $user_id = $_POST['user_id'];
            $venue = $_POST['venue'];

            $data = $_POST;
            foreach (['save', 'record_id', 'id'] as $field) {
                unset($field,$data);
            }

            if(isset($Event->id)) {
                $id = $_POST['record_id'];
                if(Event::where('user_id', $user_id)
                    ->where('gathering_type', $gathering_type)
                    ->exists()) {
                    $errors[] = 'Record already exists with for user';
                }else{
                    $Event->save($data);
                }
                $status = 'updated';
            }else {
                $status = 'added';
                if(Event::where(compact('name', 'Event_id'))->exists()) {
                    $message = 'Record already exists with same name';
                    $error = true;
                }else{
                    $Event->save($data);
                }
            }
            if(!count($errors)) {
                $message = "Record " . $status;
                $target_dir = "uploads/";
            }
        }
    }

}catch (Exception $exception){
    throw $exception;
}


?>
<?php
    if(count($errors)) {
        foreach ($errors as $message) { ?>
            <p><?php echo $message; ?></p>
            <?php
        }
    }
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" enctype="multipart/form-data">
    <?php if($Event->id) { ?>
        <input type="hidden" name="record_id" value="<?php echo $Event->id; ?>" placeholder="Event Name" required>
    <?php } ?>
    <div>
        Number of People:
        <input type="text" name="number_of_people" value="<?php echo $Event->number_of_people; ?>" placeholder="Number of People" required>
    </div>
    <div>
        Number of waiters:
        <input type="text" name="number_of_waiters" value="<?php echo $Event->number_of_waiters; ?>" placeholder="Number of waiters" required>
    </div>

    <div>
        <select name="gathering_type">
            <?php foreach (['WEDDING','BIRTHDAY','GET TOGETHER','CORPORATE FUNCTIONS','KITTY PARTY','FOOD CATERING'] as $type) {
                ?>
                <option value="<?php echo $type; ?>" <?php if($Event->gethering_type == $type) echo 'selected'; ?>><?php echo $type; ?></option>
                <?php
            }?>
        </select>
    </div>

  <div>
      Venue
      <textarea required name="details"><?php echo $Event->venue; ?></textarea>
  </div>
    <input type="submit" name="save" value="Save" />
</form>
<?php
include 'list.php';
?>