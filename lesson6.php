<?php 
    session_start();
    error_reporting( error_reporting() & ~E_NOTICE );
    
    if (isset($_GET['del'])){
      unset($_SESSION['advert'][$_GET['del']]);    
    }
    if (isset($_GET['show'])){
      $show= $_SESSION['advert'][$_GET['show']]; 
    }
    
    if (isset($_GET['show']) && $_SESSION['advert'][$_GET['show']]['allow_mails']==0){
        $check="checked";
    }if (isset($_GET['show']) && $_SESSION['advert'][$_GET['show']]['allow_mails']=='') {
        $check=" ";
    }
    
    if (isset($_GET['show']) && $_SESSION['advert'][$_GET['show']]['private']==0){
        $check0="checked"; 
        $check1=" ";
    }else{
        $check1="checked"; 
        $check0=" ";
    }
    
    if (isset($_GET['show']) && isset($_POST['main_form_submit'])){
        unset($_SESSION['advert'][$_GET['show']]);
        output_advert();
    }else {
        output_advert();
    }
?>
<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>FORM</title>
        <style type="text/css"><?php include './style.css'; ?></style>  
    </head>
    <body>
        <form  method="post" id="f_item" class="f js-submit">
            <div class="form-row-indented chec" id="chec"> 
                <label class="form-label-radio">
                    <input type="radio" <?php echo $check1?> value="1" name="private">Частное лицо
                </label>
                <label class="form-label-radio">
                    <input type="radio" <?php echo $check0 ?> value="0" name="private">Компания
                </label> 
            </div>
            <div class="form-row"> 
                <label for="fld_seller_name" class="form-label">
                    <b id="your-name">Ваше имя</b>
                </label>
                <input type="text" maxlength="40" class="form-input-text" value="<?= $show['name']?>" name="name" id="fld_seller_name">
            </div>
            <div class="form-row"> 
                <label for="fld_email" class="form-label">Электронная почта</label>
                <input type="text" class="form-input-text" value="<?= $show['email']?>" name="email" id="fld_email">
            </div>
           
            <div class="form-row-indented"> 
                <label class="form-label-checkbox" for="allow_mails"> 
                    <input type="checkbox" <?php echo $check ?> value="0" name="allow_mails" id="allow_mails" class="form-input-checkbox">
                    <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> 
                </label> 
            </div> 
                
            <div class="form-row"> 
                <label id="fld_phone_label" for="fld_phone" class="form-label">Номер телефона</label> 
                <input type="text" class="form-input-text" value="<?= $show['phone']?>" name="phone" id="fld_phone">
            </div>
            <div id="f_location_id" class="form-row form-row-required"> 
                <label for="region" class="form-label">Город</label> 
                    <?php
                        if (isset($_GET['show'])){
                            $citys = array('641780'=>'Новосибирск','641490'=>'Барабинск','641510'=>'Бердск','641510'=>'Бердск','641600'=>'Искитим','641630'=>'Колывань','641510'=>'Бердск','641510'=>'Бердск','641510'=>'Бердск','641680'=>'Краснообск','641710'=>'Куйбышев','641760'=>'Мошково');
                            $gorod = $_SESSION['advert'][$_GET['show']]['location_id'];

                            echo '<select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
                            <option value="">-- Выберите город --</option>
                            <option class="opt-group" disabled="disabled">-- Города --</option>';
                                foreach($citys as $number=>$city){
                                    $selected = ($number==$gorod) ? 'selected=""' : ''; 
                                    echo '<option data-coords=",," '.$selected.' value="'.$number.'">'.$city.'</option>'; 
                                }
                            echo '</select>'; 
                        }  else {
                            $citys = array('641780'=>'Новосибирск','641490'=>'Барабинск','641510'=>'Бердск','641510'=>'Бердск','641600'=>'Искитим','641630'=>'Колывань','641510'=>'Бердск','641510'=>'Бердск','641510'=>'Бердск','641680'=>'Краснообск','641710'=>'Куйбышев','641760'=>'Мошково');
                            $gorod = $_SESSION['advert']['location_id'];

                            echo '<select title="Выберите Ваш город" name="location_id" id="region" class="form-input-select"> 
                            <option value="">-- Выберите город --</option>
                            <option class="opt-group" disabled="disabled">-- Города --</option>';
                                foreach($citys as $number=>$city){
                                    $selected = ($number==$gorod) ? 'selected=""' : ''; 
                                    echo '<option data-coords=",," '.$selected.' value="'.$number.'">'.$city.'</option>'; 
                                }
                            echo '</select>'; 
                        }  
                    ?>
                
            </div>
            <div class="form-row"> 
                <label for="fld_category_id" class="form-label">Категория</label> 
                    <?php
                        if (isset($_GET['show'])){
                            $category_all = array(
                                'Транспорт'=> array(
                                    '9'=>'Автомобили с пробегом','109'=>'Новые автомобили','14'=>'Мотоциклы и мототехника'
                                ),
                                'Недвижимость'=> array(
                                    '24'=>'Квартиры','23'=>'Комнаты','25'=>'Дома, дачи, коттеджи'
                                ),
                                'Работа'=>array(
                                    '111'=>'Вакансии (поиск сотрудников)','112'=>'Резюме (поиск работы)'
                                )
                            );
                            $category = $_SESSION['advert'][$_GET['show']]['category_id'];
                            echo '<select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> 
                                <option value="">-- Выберите категорию --</option>';
                                foreach ($category_all as $sKey => $aFamily) {
                                    echo '<option class="opt-group" disabled="disabled">'.$sKey.'</option>';
                                    foreach ($aFamily as $ssKey => $aaFamily) {
                                        $selected = ($category==$ssKey) ? 'selected=""' : ''; 
                                        echo '<option data-coords=",," '.$selected.' value="'.$ssKey.'">'.$aaFamily.'</option>';
                                    }
                            } 

                            echo '</select>'; 
                        }else {
                            $category_all = array(
                                'Транспорт'=> array(
                                    '9'=>'Автомобили с пробегом','109'=>'Новые автомобили','14'=>'Мотоциклы и мототехника'
                                ),
                                'Недвижимость'=> array(
                                    '24'=>'Квартиры','23'=>'Комнаты','25'=>'Дома, дачи, коттеджи'
                                ),
                                'Работа'=>array(
                                    '111'=>'Вакансии (поиск сотрудников)','112'=>'Резюме (поиск работы)'
                                )
                            );
                            $category = $_SESSION['advert']['category_id'];
                            echo '<select title="Выберите категорию объявления" name="category_id" id="fld_category_id" class="form-input-select"> 
                                <option value="">-- Выберите категорию --</option>';
                                foreach ($category_all as $sKey => $aFamily) {
                                    echo '<option class="opt-group" disabled="disabled">'.$sKey.'</option>';
                                    foreach ($aFamily as $ssKey => $aaFamily) {
                                        $selected = ($category==$ssKey) ? 'selected=""' : ''; 
                                        echo '<option data-coords=",," '.$selected.' value="'.$ssKey.'">'.$aaFamily.'</option>';
                                    }
                            } 

                            echo '</select>'; 
                        }
                    ?>
                </select> 
            </div>

            <div style="display: none;" id="params" class="form-row form-row-required"> 
                <label class="form-label ">
                    Выберите параметры
                </label> 
                <div class="form-params params" id="filters"></div> 
            </div>
            
            <div id="f_title" class="form-row f_title"> 
                <label for="fld_title" class="form-label">Название объявления</label> 
                <input type="text" maxlength="50" class="form-input-text-long" value="<?= $show['title']?>" name="title" id="fld_title"> 
            </div>
            <div class="form-row"> 
                <label for="fld_description" class="form-label" id="js-description-label">Описание объявления</label> 
                <textarea maxlength="3000" placeholder="<?= $show['description']?>" value="" name="description" id="fld_description" class="form-input-textarea"></textarea> 
            </div>
            <div id="price_rw" class="form-row rl"> 
                <label id="price_lbl" for="fld_price" class="form-label">Цена</label> 
                <input type="text" maxlength="9" class="form-input-text-short" value="<?= $show['price']?>" name="price" id="fld_price">&nbsp;
                <span id="fld_price_title">руб.</span> 
            </div>
            <div class="form-row-indented form-row-submit b-vas-submit" id="js_additem_form_submit">
                <div class="vas-submit-button pull-left"> 
                    <span class="vas-submit-border"></span> 
                    <span class="vas-submit-triangle"></span> 
                    <input type="submit" value="Далее" id="form_submit" name="main_form_submit" class="vas-submit-input"> 
                </div>
            </div>
        </form>
        
        <?php 
        function output_advert(){
            $_SESSION['advert'][] = $_POST;
            echo '<span style="border:2px dotted #444; padding:20px; display:block;">';
                echo '<span style="float:left;min-width: 152px;">';
                    echo 'Название объявления'.'<br/>';
                echo '</span>';
                echo '<span style="float:left;margin: 0 50px 0 50px;"">|</span>';
                echo '<span style="float:left;min-width: 100px;">';
                    echo 'Цена'.'<br/>';
                echo '</span>';
                echo '<span style="float:left;margin: 0 50px 0 50px;">|</span>';
                echo '<span style="float:left;min-width: 200px;">';
                    echo 'Имя'.'<br/>';
                echo '</span>';
                echo '<span style="float:left; margin: 0 50px 0 50px;">|</span>';
                echo '<span style="float:left;min-width: 100px;">';
                    echo 'Удалить'.'<br/>';
                echo '</span>';
                echo '<span style="float:left; margin: 0 50px 0 50px;">|</span>';
                echo '<div style="clear:both; margin-bottom: 10px;";></div>'; 
            echo '</span>';
            foreach ($_SESSION['advert'] as $key => $value){
                if (isset($value['title']) && isset($value['price']) && isset($value['name'])) {
                    echo '<span style="border:2px dotted #444; padding:20px; display:block;">';
                        echo '<span style="float:left;min-width: 152px;">';
                            echo '<a href="http://xaver.loc/lesson6/?show='.$key.'">'.$value['title'].'</a>'.'<br/>';
                        echo '</span>';
                        echo '<span style="float:left;margin: 0 50px 0 50px;"">|</span>';
                        echo '<span style="float:left;min-width: 100px;">';
                            echo $value['price'].'<br/>';
                        echo '</span>';
                        echo '<span style="float:left;margin: 0 50px 0 50px;">|</span>';
                        echo '<span style="float:left;min-width: 200px;">';
                            echo $value['name'].'<br/>';
                        echo '</span>';
                        echo '<span style="float:left; margin: 0 50px 0 50px;">|</span>';
                        echo '<span style="float:left;min-width: 100px;">';
                            echo '<a href="http://xaver.loc/lesson6/?del='.$key.'">'.'Удалить'.'</a>'.'<br/>';
                        echo '</span>';
                        echo '<span style="float:left; margin: 0 50px 0 50px;">|</span>';
                        echo '<div style="clear:both; margin-bottom: 10px;";></div>'; 
                    echo '</span>'; 
                 }
            }
            echo '<br/>'.'<br/>';
            }
        ?>
    </body>
</html>   