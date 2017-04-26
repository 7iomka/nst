<div class="calculator__steps">

	<div class="calculator__steps__line">
		<div id="block1" class="step one">
			<p class="title">Выбор<br>материала</p>
			<div class="input-wrapper">
				<input id="radio-b1-2" data-name="Стекло" data-name-id="1" name="radio-b1" type="radio" onClick="loadMaterials(1,'block2');setBlock(3);" />

				<label for="radio-b1-2"></label>
<label for="radio-b1-2">Стекло</label>
			</div>
			<div class="input-wrapper">
				<input id="radio-b1-3" data-name="Зеркало" data-name-id="2" name="radio-b1" type="radio" onClick="loadMaterials(2,'block2');setBlock(3);" />

				<label for="radio-b1-3"></label>
<label for="radio-b1-3">Зеркало</label>
			</div>
		</div>
		<div id="block2" class="step two">
		  <div class="shadow">
				<div class="shadow__content">
						<p class="number">2</p>
						<p class="title">Вид стекла</p>
				</div>
	    </div>
			<div id="block2_cont">
				<p class="title">Вид<br>стекла</p>

				<div class="input-wrapper clearfix">
					<input id="radio-b2-1-1" data-material-id="1" data-harding="1" data-img-src="1_material.png" onChange="loadMaterialImage('1');loadTypes('1','block3');setBlock(4);Raschet();" name="radio-b2" type="radio" />
					<label for="radio-b2-1-1"></label>
<label for="radio-b2-1-1">Прозрачное</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="radio-b2-1-2" data-material-id="2" data-harding="1" data-img-src="2_material.png" onChange="loadMaterialImage('2');loadTypes('2','block3');setBlock(4);Raschet();" name="radio-b2" type="radio" />
					<label for="radio-b2-1-2"></label>
<label for="radio-b2-1-2">Осветлённое</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="radio-b2-1-3" data-material-id="3" data-harding="1" data-img-src="3_material.png" onChange="loadMaterialImage('3');loadTypes('3','block3');setBlock(4);Raschet();" name="radio-b2" type="radio" />
					<label for="radio-b2-1-3"></label>
<label for="radio-b2-1-3">Матовое</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="radio-b2-1-5" data-material-id="5" data-harding="1" data-img-src="5_material.png" onChange="loadMaterialImage('5');loadTypes('5','block3');setBlock(4);Raschet();" name="radio-b2" type="radio" />
					<label for="radio-b2-1-5"></label>
<label for="radio-b2-1-5">Серое</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="radio-b2-1-4" data-material-id="4" data-harding="1" data-img-src="4_material.png" onChange="loadMaterialImage('4');loadTypes('4','block3');setBlock(4);Raschet();" name="radio-b2" type="radio" />
					<label for="radio-b2-1-4"></label>
<label for="radio-b2-1-4">Бронза</label>
					<span class="question"></span>
				</div>
			</div>
		</div>
		<div id="block3" class="step three">
			<div class="shadow">
				<div class="shadow__content">
					<p class="number">3</p>
					<p class="title">Толщина стекла</p>
				</div>
			</div>
			<div id="block3_cont">
				<p class="title">Толщина<br>стекла</p>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">4 мм</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">6 мм</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">8 мм</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">10 мм</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">12 мм</label>
					<span class="question"></span>
				</div>
			</div>
		</div>

		<div id="block4" class="step four">
							<div class="shadow">
								<div class="shadow__content">
									<p class="number">4</p>
									<p class="title">Форма изделия</p>
								</div>
							</div>
							<p class="title">Форма изделия</p>
							<div class="input-wrapper marginless clearfix">
								<input id="radio-b4-1" name="radio-b4" type="radio" onClick="$('.forms_input').attr('disabled',true);$('.forms_input').val('');$('#form1_w_s').attr('disabled',false);$('#form1_h_s').attr('disabled',false);setBlock(5);">
								<label for="radio-b4-1"></label>
<label for="radio-b4-1">Прямоугольник</label>
								<div class="question question_form">
					        <div class="qtip_content">
					          <p class="title qtip_title">ПРЯМОУГОЛЬНИК</p>
										<div class="qtip_description">
					          		<div class="tip_div">Max размер 3210х2250мм <p></p><p>  УКАЗЫВАЙТЕ РАЗМЕРЫ В МИЛЛИМЕТРАХ!</p></div>
										</div>
					        </div>
						    </div>
							</div>
							<div>
								<input onInput="checkInputs('form1');" id="form1_w_s" class="forms_input form-field margined-left" type="text" placeholder="Длина"><span class="units">мм</span>
							</div>
							<div style="margin-bottom: 15px;">
								<input onInput="checkInputs('form1');" id="form1_h_s" class="forms_input form-field margined-left last-input" type="text" placeholder="Ширина"><span class="units">мм</span>
							</div>
							<div class="input-wrapper marginless clearfix">
								<input id="radio-b4-2" name="radio-b4" type="radio" onClick="$('.forms_input').attr('disabled',true);$('.forms_input').val('');$('#form2_diametr').attr('disabled',false);setBlock(5);">
								<label for="radio-b4-2"></label>
<label for="radio-b4-2">Круг</label>
								<div class="question question_form">
						       <div class="qtip_content">
						          <p class="title qtip_title">КРУГ</p>
											<div class="qtip_description">
						          		<div class="tip_div">Min диаметр 150 мм.
												</div>
												<p>Маx диаметр 2200 мм</p>
												<p> УКАЗЫВАЙТЕ РАЗМЕРЫ В МИЛЛИМЕТРАХ!</p>
										</div>
						      </div>
						    </div>
							</div>
							<div style="margin-bottom: 30px;">
								<input id="form2_diametr" onInput="setBlock(5);checkInputs('form2');" class="forms_input form-field margined-left last-input" type="text" placeholder="Диаметр"><span class="units">мм</span>
							</div>
							<div class="input-wrapper marginless clearfix">
								<input id="radio-b4-3" name="radio-b4" type="radio" onClick="$('.forms_input').attr('disabled',true);$('.forms_input').val('');$('#form3_w_s').attr('disabled',false);$('#form3_h_s').attr('disabled',false);setBlock(5);">
								<label for="radio-b4-3"></label>
<label for="radio-b4-3">Фигура</label>
								<div class="question question_form">
									<div class="qtip_content">
										<p class="title qtip_title">ФИГУРА</p>
										<div class="qtip_description">
												<div class="tip_div">Указывайте размеры прямоугольника, в который умещается фигура.
											</div>
											<p> УКАЗЫВАЙТЕ РАЗМЕРЫ В МИЛЛИМЕТРАХ!</p>
										</div>
									</div>
								</div>
							</div>
							<div>
								<input onInput="setBlock(5);checkInputs('form3');" id="form3_w_s" class="forms_input form-field margined-left" type="text" placeholder="Длина"><span class="units">мм</span>
							</div>
							<div>
								<input onInput="setBlock(5);checkInputs('form3');" id="form3_h_s" class="forms_input form-field margined-left last-input" type="text" placeholder="Ширина"><span class="units">мм</span>
							</div>
				</div>
		<div id="block5" class="step five">
			<div class="shadow">
				<div class="shadow__content">
					<p class="number">5</p>
					<p class="title">Обработка</p>
				</div>
			</div>
			<p class="title">Обработка</p>
			<div id="block5_cont">
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">Резка</label>
					<span class="question"></span>
				</div>
				<!-- <div class="input-wrapper clearfix"> <input id="" name="" type="radio"><label for=""></label>
<label for="">Шлифовка</label> <span class="question"></span> </div> -->
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">Полировка</label>
					<span class="question"></span>
				</div>
				<div class="input-wrapper clearfix">
					<input id="" name="" type="radio">
					<label for=""></label>
<label for="">Фацет</label>

					<span class="question"></span>
				</div>
			</div>
		</div>
		<div id="block6" class="step six">
				<div class="shadow">
					<div class="shadow__content">
							<p class="number">6</p>
						<p class="title">Дополнительно</p>
					</div>
				</div>
				<p class="title">Дополнительно</p>
				<div id="el_harding" class="input-wrapper">
					<input id="checkbox-b6-1" type="checkbox" onClick="check_dates_calc();Raschet();">
					<label for="checkbox-b6-1"></label>
<label for="checkbox-b6-1">Закалка</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">ЗАКАЛКА СТЕКЛА</p>
							<div class="qtip_description">
									<div class="tip_div">Термическая обработка после которой стекло становится прочнее (в 7 раз!), устойчивым к ударам и перепадам температуры. В случае механического разрушения стекло распадается на безопасные фрагменты.
								</div>
							</div>
							<img src="/img/images_tips/4_tip.jpg" />
						</div>
					</div>
				</div>

				<div class="input-wrapper marginless">
					<input id="checkbox-b6-2" type="checkbox" onClick="check_dates_calc();Raschet();">
					<label for="checkbox-b6-2"></label>
<label for="checkbox-b6-2">Отверстия</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">СВЕРЛЕНИЕ ОТВЕРСТИЙ</p>
							<div class="qtip_description">
									<div class="tip_div">Сквозные отверстия в стекле. Указывайте количество, диаметр и расположение отверстий на стекле уточняйте на прилагаемом макете.</div>
							</div>
						</div>
					</div>
				</div>
				<div>
					<input id="text-b6-1" type="text" onInput="Raschet();" class="block6_input form-field short margined-left" type="text" placeholder="Шт">
				</div>

				<div class="input-wrapper marginless">
					<input id="checkbox-b6-3" type="checkbox" onClick="check_dates_calc();Raschet();">
					<label for="checkbox-b6-3"></label>
<label for="checkbox-b6-3">Вырезы</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">ВЫРЕЗЫ</p>
							<div class="qtip_description">
									<div class="tip_div">Указывайте количество, точную информацию уточняйте на прилагаемом макете.</div>
							</div>
						</div>
					</div>
			  </div>
				<div>
					<input id="text-b6-2" onInput="Raschet();" class="block6_input form-field short margined-left" type="text" placeholder="Шт">
				</div>

				<div class="input-wrapper marginless">
					<input type="checkbox" id="checkbox-b6-4" onClick="check_dates_calc();Raschet();">
					<label for="checkbox-b6-4"></label>
<label for="checkbox-b6-4">Скругления углов</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">СКРУГЛЕНИЕ УГЛОВ</p>
							<div class="qtip_description">
									<div class="tip_div">В ряде случаев 90 градусные углы на прямоугольных по форме стеклах требуют скругления. Указывайте количество, радиусы скругления уточняйте на прилагаемом макете.</div>
							</div>
						</div>
					</div>
				</div>
				<div>
					<input id="text-b6-3" onInput="Raschet();" class="form-field short margined-left" type="text" placeholder="Шт">
				</div>

				<div id="div-b6-5" class="input-wrapper marginless">
					<input id="checkbox-b6-5" type="checkbox" onClick="Raschet();">
					<label for="checkbox-b6-5"></label>
<label for="checkbox-b6-5">Пленка безопасности</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">ПЛЕНКА БЕЗОПАСНОСТИ</p>
							<div class="qtip_description">
									<div class="tip_div">Защитная плёнка наносится на обратную сторону зеркал для предотвращения распадения зеркала на опасные крупные осколки при разрушении.</div>
							</div>
						</div>
					</div>
				</div>
				<div id="div-b6-6" class="input-wrapper marginless" style="margin-top: 10px;">
					<input id="checkbox-b6-6" type="checkbox" onClick="Raschet();">
					<label for="checkbox-b6-6"></label>
<label for="checkbox-b6-6">Бронепленка</label>
					<div class="question question_dop">
						<div class="qtip_content">
							<p class="title qtip_title">Бронепленка</p>
							<div class="qtip_description">
									<div class="tip_div">применимо только к стеклу и к толщинам от 6 и выше</div>
							</div>
						</div>
					</div>
				</div>
				<div style="clear: both;margin-top: 10px;"></div>
				<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
					<div id="drop">
						<a class="btn btn--yellow btn--file-upload"><i class="upload_icon">&nbsp;</i> Прикрепить макет</a>
						<input type="file" name="upl" multiple />
					</div>

					<ul>
						<!-- The file uploads will be shown here -->
					</ul>

				</form>
		</div>

		<div id="block7" class="step seven">
			<div class="shadow">
				<div class="shadow__content">
					<p class="number">7</p>
					<p class="title">Способ доставки</p>
				</div>
			</div>
			<p class="title">Способ доставки</p>
			<div class="input-wrapper" style="margin-bottom: 20px;">
				<input id="radio-b7-1" data-num="0" name="radio-b7" type="radio" onClick="$('#block8 div.shadow').addClass('shadow-hidden');setBlock(9);check_dates_calc();Raschet();" checked>
<label for="radio-b7-1"></label>
<label for="radio-b7-1">Самовывоз</label>

				<div class="question question_dostavka" style="">
					<div class="qtip_content">
						<p class="title qtip_title">Самовывоз</p>
						<div class="qtip_description">
								<div class="tip_div"></div>
						</div>
					</div>
				</div>

				<p class="adress lefted">м.Тимирязевская. Дмитровское шоссе 11</p>
			</div>
			<div class="input-wrapper">
				<input id="radio-b7-2" data-num="1" name="radio-b7" type="radio" onClick="$('#block8 div.shadow').addClass('shadow-hidden');setBlock(9);check_dates_calc();Raschet();">
				<label for="radio-b7-2"></label>
				<label for="radio-b7-2">Доставка в пределах <font style="padding-left: 30px;">МКАД</font></label>

				<div class="question question_dostavka" style="">
			             <div class="qtip_content">
			                  <p class="title qtip_title">Доставка в пределах МКАД</p>
												<div class="qtip_description">
			                  		<div class="tip_div">Доставка осуществляется до подъезда!nРазгрузка осуществляется силами Заказчика.</div>
												</div>
			                                  </div>
			            </div>

			</div>
			<textarea class="lefted" name="text-b7-1" id="text-b7-1" placeholder="Адрес" style="margin-bottom: 5px;"></textarea>
			<div class="input-wrapper">
				<input id="radio-b7-3" data-num="2" name="radio-b7" type="radio" onClick="$('#block8 div.shadow').addClass('shadow-hidden');setBlock(9);check_dates_calc();Raschet();">
				<label for="radio-b7-3"></label>
				<label for="radio-b7-3">Доставка за <font style="padding-left: 30px;">пределами МКАД</font></label>

				<div class="question question_dostavka" style="margin-top: -20px;">
					<div class="qtip_content">
						<p class="title qtip_title">Доставка в пределах 30км от МКАД</p>
						<div class="qtip_description">
								<div class="tip_div">Доставка осуществляется до подъезда!nРазгрузка осуществляется силами Заказчика.</div>
						</div>
					</div>
				</div>

			</div>
			<textarea class="lefted" name="text-b7-2" id="text-b7-2" placeholder="Адрес"></textarea>
		</div>
		<div id="block8" class="step eight">
			<div class="shadow">
				<div class="shadow__content">
						<p class="number">8</p>
					<p class="title">Сроки</p>
				</div>
			</div>
			<p class="title">Сроки</p>
			<div class="question question_calendar" style="margin-top: -60px;">
				<div class="qtip_content">
					<p class="title qtip_title">КОГДА?</p>
					<div class="qtip_description">
							<div class="tip_div">Указывается ближайший срок реализации заказа или дата возможной доставки.</div>
					</div>
				</div>
			</div>
			<div id="datepicker" class=""></div>
			<input type="hidden" id="date_value">
			<input type="hidden" id="date_num_value">
		</div>
		<div id="block9" class="step nine final-step">
			<div class="shadow">
				<div class="shadow__content">
						<p class="number">9</p>
					<p class="title">Стоимость
						<br>Вашего заказа</p>
				</div>
			</div>
			<p class="title">Стоимость Вашего заказа</p>
			<div class="price">
				<div class="price__line price__line--current"><span id="resultCalc">0</span> руб</div>
				<div class="price__line price__line--next"><span id="resultCalcNext">0</span> руб</div>
			</div>
			<div class="ammount-nav">
				<p class="amount"> Количество: </p><!--
				--><span class="minus" onClick="change_cnt(-1);">–</span><!--
				--><input type="text" id="cnt" class="count" value="1"><!--
				--><span class="plus" onClick="change_cnt(+1);">+</span>
			</div>
			<div class="attention">Обратите внимание, что размеры указаны в (мм)</div>
			<button class="btn btn--medium btn--start-pay-order online-order" data-url="online-order" data-remodal-target="order-now" onClick="checkOrder();return(false);">Сделать заказ</button>
			<input type="reset" onClick="sbros_calc();return(false);" value="Сбросить текущий расчет">
		</div>
	</div>

</div> <!-- END CALCULATOR STEPS -->
