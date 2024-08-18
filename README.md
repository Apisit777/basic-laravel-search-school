<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

<!-- [ View File name : preview_view.php ] -->

<style>

</style>

<div class='min-h-screen flex justify-center items-center'>
	<!-- <button type="button" onclick="pagePrint(myform)">Print</button> -->
	<div id="myform" class="form justify-center items-center bg-white">
		<!-- <button onclick="window.print()" class="bg-white text-white px-4 rounded shadow hover:shadow-xl hover:bg-white duration-300"> -->
		<div class="col-sm-12 col-md-12 mb-3">
			<div class="row">
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
						<label for="customer_code">รหัสลูกค้า</label>
						<input type="text" class="form-control" id="customer_code" name="customer_code" value="{record_customer_code}" disabled />
				</div>
				<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<label for="">ชื่อ-นามสกุล-ลูกค้า</label>
					<select id="id" name="id" value="{list_user_id}" disabled>
						<option value="-">--- กรุณาเลือก ---</option>
						<?php
							$query_result = $this->db->query("SELECT id, customer_firstname, customer_lastname
																FROM customers   
																WHERE id = id")->result();
							foreach ($query_result as $row) {
						?>
							<option value="<?= $row->id; ?>"><?= $row->customer_firstname ." ". $row->customer_lastname ?></option>
						<?php
							}
						?>
					</select>						
				</div>
			</div>
		</div>
		<div class="grid grid-cols-5 grid-rows-3 mb-2 gap-2">
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อายุ ..........</label>
			<input id="age" name="age" value="{list_register_age}" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">เบอร์โทร</label>
			<input id="" name="" value="{list_customer_phone_number}" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">รายได้สุทธิ</label>
			<input id="net_income" name="net_income" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ฐานเงินเดือน</label>
			<input id="base_salary" name="base_salary" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้สินเชื่อ</label>
			<input id="debt_burden" name="debt_burden" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">สัญญา</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รถยนต์(ไม่รี)</label>
			<input id="car_debt_n" name="car_debt_n" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">Dept</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รถยนต์(รี)</label>
			<input id="car_debt_y" name="car_debt_y" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ประมาณการดอกเบี้ยเดิม</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้ที่ไม่ปิด</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด (+/-)</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">เงินต้นของเดิม</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">งวดผ่อนกับทางบริษัท</label>
			<input id="installment_installments_with_company" name="installment_installments_with_company" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-[#df3434] rounded-sm text-sm text-center grid content-center justify-items-stretch">ยอดผ่อนของเดิม</label>
			<input id="original_installment_amount" name="original_installment_amount" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อื่น ๆ ถ้ามี</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">จำนวนห้องที่กู้ได้</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-3 m-0 p-0"></label>
		</div>
		<div class="flex justify-center items-center 2xl:text-2xl xl:text-xl lg:text-lg md:text-md sm:text-sm">
			<h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500" style="font-size: 16px;">ประมาณการผ่อนโปรแกรม OPM</h2>
		</div>
		<div class="grid grid-rows-3 grid-flow-col gap-2 mt-3 pb-3">
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(20-28%)" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="บัตรกดเงินสด(20-28%)" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="บัตรกด(16-20%)" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อ OD (6-10%)" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(4-10%)" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="สินเชื่อส่วนบุคคล(0-3%)" />
			<input id="" name="" class="row-span-3 col-span-2 m-0 p-0 dark:text-white rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500 text-xl" placeholder="ผ่อนเดิมของลูกค้า" />
			<input id="" name="" class="row-span-3 col-span-2 m-0 p-0 dark:text-white rounded-sm dark:bg-[#347BA4] text-center focus:border-blue-500 text-xl" placeholder="OPM : 3" />
		</div>
		<div class="grid grid-rows-3 grid-flow-col gap-2 mt-3">
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">% ดอกเบี้ย .................</label>
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้</label>
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">จำนวนเดือน</label>
			<input id="" name="" class="row-span-1 col-span-6 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="20.00%" />
			<input id="cl_total_debt_burden1" name="cl_total_debt_burden1" class="row-span-1 col-span-6 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="11"/>
			<input id="" name="" class="row-span-1 col-span-6 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="18.34%" />
			<input id="cl_total_debt_burden2" name="cl_total_debt_burden2" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="22" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
			<input id="" name="" value="ยอดที่ต้องชำระ" class="row-span-1 col-span-3 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" disabled />
			<input id="cl_total_debt_burden3" name="cl_total_debt_burden3" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="33" />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="60 เดือน" />
		</div>
		<div class="grid grid-rows-3 grid-flow-col gap-2 mt-3">
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่างวดผ่อนต่อเดือน</label>
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่างวดผ่อน(ทั้งหมด)</label>
			<label class="row-span-1 col-span-1 m-0 p-0 text-center text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ดอกเบี้ย(ทั้งหมด)</label>
			<input id="monthly_installment_payment" name="monthly_installment_payment" class="row-span-1 col-span-6 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#FFCC45] text-center focus:border-blue-500" placeholder="1" disabled
			/>
			<input id="installment_payments_all1" name="installment_payments_all1" class="row-span-1 col-span-6 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="2" disabled />
			<input id="interest_all1" name="interest_all1" class="row-span-1 col-span-6 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="3" disabled />
			<input id="total_original_installment_amount2" name="total_original_installment_amount2" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#649cbd] text-center focus:border-blue-500" placeholder="4" disabled />
			<input id="installment_payments_all2" name="installment_payments_all2" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="5" disabled />
			<input id="interest_all2" name="interest_all2" class="row-span-1 col-span-3 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="6" disabled />
			<input id="total_original_installment_amount3" name="total_original_installment_amount3" class="row-span-1 col-span-3 m-0 p-0 text-white rounded-sm dark:bg-[#347BA4] text-center focus:border-blue-500" placeholder="7" disabled />
			<input id="installment_payments_all3" name="installment_payments_all3" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="8" disabled />
			<input id="" name="" class="row-span-1 col-span-3 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" placeholder="9" disabled />
		</div>
		<div class="grid grid-rows-3 grid-flow-col gap-2 mt-3 pb-3">
			<div class="col-span-2 dark:text-white rounded-sm dark:bg-[#E9ECEF]"></div>
			<label class="row-span-3 col-span-1 m-0 p-0 text-black rounded-sm text-sm dark:bg-[#E9ECEF] text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์</label>
			<input id="" name="" class="row-span-3 m-0 p-0 dark:text-white rounded-sm dark:bg-[#236C6B] text-center focus:border-blue-500 text-xl" placeholder="" disabled />
			<div class="col-span-2 dark:text-white rounded-sm dark:bg-[#E9ECEF]"></div>
		</div>
		<ul class="pt-2 space-y-2 border-t border-black dark:border-blue-500">
		<div class="grid grid-cols-5 grid-rows-3 mt-3 mb-3 gap-2">
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ผลตอบแทน</label>
			<input id="Returns" name="Returns" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนเงินต้น 1 แสนละ</label>
			<input id="installment_of_100k_b" name="installment_of_100k_b" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้เดิมคิดเป็น</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้ส่วนเกิน 4 แสน</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด 20 เท่า</label>
			<input id="approval_closed_20_times" name="approval_closed_20_times" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">คิดเป็นต่อหน่วย 1 แสน</label>
			<input id="calculated_per_unit_100k" name="calculated_per_unit_100k" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้เกิน</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนเงินต้นช่วงแรก</label>
			<input id="principle" name="principle" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติปิด (หนี้จริง)</label>
			<input id="approve_closing_actual_debt" name="approve_closing_actual_debt" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500"/>

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าผ่อนจ่าย (4 เดือนแรก)</label>
			<input id="c_pay_in_installments_first_4_m" name="c_pay_in_installments_first_4_m" class="col-span-1 m-0 p-0 text-white rounded-sm dark:bg-[#347BA4] text-center focus:border-blue-500"
			/>

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าช่วยปิด</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ลูกค้าผ่อนจ่าย (เดือนที่ 5 เป็นต้นไป)</label>
			<input id="c_pay_in_installments_5_m_onw" name="c_pay_in_installments_5_m_onw" class="col-span-1 m-0 p-0 text-white rounded-sm dark:bg-[#347BA4] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">อนุมัติคิดเป็น</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ประมาณการประกันชีวิต (บริษัท) *จ่ายแยก*</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ดอกเบี้ยของเดิม</label>
			<input id="original_interest" name="original_interest" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ผ่อนกับทางบริษัท (ทั้งสิ้น)</label>
			<input id="installments_with_the_company_all" name="installments_with_the_company_all" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ภาระหนี้รวม</label>
			<input id="total_debt_burden" name="total_debt_burden" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">เงินรีไฟแนนซ์รถยนต์ (70%)</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">พรีวงเงินที่สามารถกู้ได้</label>
			<input id="Pre_borrow_amount_that_can_be_borrowed" name="Pre_borrow_amount_that_can_be_borrowed" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้คงเหลือสุทธิ</label>
			<input id="net_outstanding_debt" name="net_outstanding_debt" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#FFCC45] text-center focus:border-blue-500" />

			<label class="col-span-3 m-0 p-0"></label>
		</div>
		<ul class="pt-4 space-y-2 border-t border-black dark:border-blue-500 mt-3 mb-3">
		
		<!-- <table class="table table-bordered text-center mb-3">
			<thread>
				<?php $i = 1 ?>
				<tr>
					<th><?php echo $i++; ?></th>
				</tr>
				<tr>
					<?php foreach($detail_bank_name_send as $row): ?>
						<td scope="col"><?php echo $row->bank_name_send; ?></td>
					<?php endforeach; ?>
				</tr>
			</thread>
			<tbody>
			</tbody>
		</table> -->

		<table class="table table-bordered text-center mb-3">
			<thread>
				<tr>
					<th scope="col">ห้อง</th>
					<?php $i = 1 ?>
					<td scope="col"><?php echo $i++; ?></td>
					<!-- <th scope="col" class="dark:bg-[#347BA4]">1</th>
					<th scope="col" class="dark:bg-[#347BA4]">2</th>
					<th scope="col" class="dark:bg-[#347BA4]">3</th>
					<th scope="col" class="dark:bg-[#347BA4]">4</th>
					<th scope="col" class="dark:bg-[#347BA4]">5</th>
					<th scope="col" class="dark:bg-[#347BA4]">6</th>
					<th scope="col" class="dark:bg-[#347BA4]">7</th>
					<th scope="col" class="dark:bg-[#347BA4]">8</th>
					<th scope="col" class="dark:bg-[#347BA4]">9</th> -->
				</tr>
					<tr>
						<td>ธนาคาร</td>
						<?php foreach($detail_bank_name_send as $key => $row): ?>
							<td scope="col"><?php echo $key ." ".$row->bank_name_send; ?></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<td>LTV</td>
						<?php foreach($detail_bank_name_send as $key => $row): ?>
							<td scope="col"><input class="room-ltv text-center" id="<?= 'room_LTV_'.$key; ?>"></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<td>วงเงินที่กู้ได้</td>
						<?php foreach($detail_bank_name_send as $key => $row): ?>
							<td scope="col"><input class="room-amount-that-can-be text-center" id="<?= 'room_amount_that_can_be_'.$key; ?>"></td>
						<?php endforeach; ?>
					</tr>
					<tr>
						<td>ค่าพัฒนาทรัพย์</td>
						<?php foreach($detail_bank_name_send as $key => $row): ?>
							<td scope="col"><input class="room-property-development-costs text-center" id="<?= 'room_property_development_costs_'.$key; ?>"></td>
						<?php endforeach; ?>
					</tr>
				<!-- <th>ธนาคาร</th>
				<th>LTV</th>
				<th>วงเงินที่กู้ได้</th>
				<th>ค่าพัฒนาทรัพย์</th> -->
			</thread>
			<tbody>
				<!-- ... data here ... -->
			</tbody>
		</table>
		<table class="table table-bordered text-center table-sm mb-3">
			<thread>
				<tr>
					<th scope="col">ประมาณการ MRTA</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">1</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">2</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">3</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">4</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">5</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">6</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">7</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">8</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">9</th>
				</tr>
				<tr>
					<td>ค่างวดผ่อน MRTA</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</thread>
			<tbody>
				<!-- ... data here ... -->
			</tbody>
		</table>
		<table class="table table-bordered text-center table-sm mb-3">
			<thread>
				<tr>
					<th scope="col">วงเงินตกแต่งบ้าน</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">1</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">2</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">3</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">4</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">5</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">6</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">7</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">8</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">9</th>
				</tr>
				<tr>
					<td>ค่างวดผ่อนตกแต่งบ้าน</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</thread>
			<tbody>
				<!-- ... data here ... -->
			</tbody>
		</table>
		<div class="flex justify-center items-center 2xl:text-md xl:text-md lg:text-md md:text-md sm:text-sm">
			<h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500 text-[#df3434]" style="font-size: 16px;">กรณีถือครองสัญญาไม่ครบ 60 เดือน ลูกค้าต้องเสียภาษี และค่าใช้จ่ายที่กรมที่ดินทุกกรณี</h2>
		</div>
		<table class="table table-bordered text-center table-sm mb-3">
			<thread>
				<tr>
					<th scope="col">ภาษีที่ดิน ณ วันโอน</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">1</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">2</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">3</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">4</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">5</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">6</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">7</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">8</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">9</th>
				</tr>
				<tr>
					<td>ค่างวดผ่อนภาษีที่ดิน</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</thread>
			<tbody>
				<!-- ... data here ... -->
			</tbody>
		</table>
		<div class="flex justify-center items-center 2xl:text-md xl:text-md lg:text-md md:text-md sm:text-sm">
			<h2 class="inline-block space-y-2 border-b border-black dark:border-blue-500" style="font-size: 16px;">กรณีลูกค้าให้นำค่าพัฒนาทรัพย์มาหักลบหนี้ หรือ MRTA</h2>
		</div>
		<div class="grid grid-cols-5 grid-rows-3 mt-3 mb-3 gap-2">
			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ให้ลูกค้า/ใช้หักอื่น ๆ)</label>
			<input id="Returns" name="Returns" class="col-span-1 m-0 p-0 text-[#df3434] rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์สุทธิ</label>
			<input id="net_property_development_cost" name="net_property_development_cost" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#a8ead5] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ไปช่วยลูกค้าปิด)</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">ค่าพัฒนาทรัพย์คงเหลือ</label>
			<input id="remaining_property_development_costs" name="remaining_property_development_costs" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#136C50] text-center focus:border-blue-500" />

			<label class="m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">นำค่าพัฒนาทรัพย์ (ไปลด MRTA)</label>
			<input id="" name="" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#E9ECEF] text-center focus:border-blue-500" />

			<label class="col-span-2 m-0 p-0 text-black rounded-sm text-sm text-center grid content-center justify-items-stretch">หนี้คงเหลือสุทธิ</label>
			<input id="net_outstanding_debt_mrta" name="net_outstanding_debt_mrta" class="col-span-1 m-0 p-0 text-black rounded-sm dark:bg-[#FFCC45] text-center focus:border-blue-500" />
		</div>
		<table class="table table-bordered text-center table-sm mb-3">
			<thread>
				<tr>
					<th scope="col">ห้อง</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">1</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">2</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">3</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">4</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">5</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">6</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">7</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">8</th>
					<th scope="col" class="dark:bg-[#347BA4] text-white">9</th>
				</tr>
				<tr>
					<td>ห้อง</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>ประมาณการ MRTA</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>ค่างวดผ่อน MRTA</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td>ลูกค้าผ่อน</td>
					<td id=""></td>
					<td id=""></td>
				</tr>
				<tr>
					<td>จำนวนงวดผ่อน</td>
					<td>60</td>
					<td>60</td>
				</tr>
			</thread>
			<tbody>
				<!-- ... data here ... -->
			</tbody>
		</table>

		<div class="divide-y divide-dashed">
			<p>หมายเหตุ : </p>
			<div></div>
		</div>

		<div class="">
			<p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">บริษัท พีจี เอสเตท ดีเวลลอปเม้นท์ จำกัด 47-47/1 หมู่ที่ 7 ตำบลคูคต อำเภอลำลูกกา จังหวัดปทุมธานี 12130 โทร. 02-077-4068</p>
			<p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">PG Estate Development Co., Ltd. 47-47/1 Moo 7 Khukhot, Lamlukka, Pathumthani 12130, Thailand. Tel. 02-077-4068</p>
			<p style="font-size: 10px; display: flex; align-items: center; justify-content: center;">(V.20230909)</p>
		</div>
	</div>
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"> 
<script src="https://cdn.tailwindcss.com"></script>
<script>

function pagePrint(myform) {
	let printdata = document.getElementById("myform");
	newwin = window.open("");
	newwin.document.write(printdata.outerHTML);
	newwin.print();
	newwin.close();
}

// let installment_of_100k_b
// let calculated_per_unit_100k
// total_original_installment_amount3

// let debt_burden = document.getElementById('debt_burden').value || "0";
// debt_burden = toStringNumber(debt_burden)
// document.getElementById('approve_closing_actual_debt').value = total_debt_burden.toLocaleString()

const list_user_id = <?=json_encode($list_user_id)?>;
console.log('list_user_id', list_user_id);

const detail_bank_name_send = <?=json_encode($detail_bank_name_send)?>;
console.log('detail_bank_name_send', detail_bank_name_send);

function mathCeil(total, ceil) {
    return Math.ceil(total / ceil) * ceil
}
function getValue(key){
	let value = document.getElementById(key).value || "0";
	value = toStringNumber(value)
 	return value
}
function setValue(key,value){
	document.getElementById(key).value = value.toLocaleString()
}

function toStringNumber(data){
 return parseFloat(data.replace(/,/g, ''));
}
function formatNumber(data){
 return data.replace(/\d(?=(?:\d{3})+$)/g, '$&,');
}
function onChangeNumber(value){
	if(isNaN(value)){
		return toStringNumber(value).toLocaleString()
	}else{
		return Number(value).toLocaleString()
	}
}

function calTotalOriginalInstallmenAamount(){
	let original_installment_amount = document.getElementById('original_installment_amount').value || "0";
	original_installment_amount = toStringNumber(original_installment_amount)
	let cl_total_debt_burden2 = document.getElementById('cl_total_debt_burden2').value || "0";
	cl_total_debt_burden2 = toStringNumber(cl_total_debt_burden2)
	let installment_payments_all1 = document.getElementById('installment_payments_all1').value || "0";
	installment_payments_all1 = toStringNumber(installment_payments_all1)

	let total_original_installment_amount = Number(original_installment_amount)
	document.getElementById('total_original_installment_amount2').value = total_original_installment_amount.toLocaleString()
	document.getElementById('installment_payments_all2').value = (total_original_installment_amount * 60).toLocaleString()
	document.getElementById('interest_all1').value = (cl_total_debt_burden2 - installment_payments_all1).toLocaleString()
	document.getElementById('interest_all2').value =  (cl_total_debt_burden2 - (total_original_installment_amount * 60)).toLocaleString()
}

document.getElementById('original_installment_amount').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	calTotalOriginalInstallmenAamount()
})

function calTotalDebt(){
	let debt_burden = getValue('debt_burden')
	let car_debt_n = getValue('car_debt_n')
	let car_debt_y = getValue('car_debt_y')

	let installment_payments_all2 = document.getElementById('installment_payments_all2').value || "0";
	installment_payments_all2 = toStringNumber(installment_payments_all2)

	let total_debt_burden = Number(debt_burden) + Number(car_debt_n) + Number(car_debt_y)
	setValue('total_debt_burden',total_debt_burden)
	setValue('approve_closing_actual_debt',total_debt_burden)
	setValue('net_outstanding_debt',total_debt_burden)

	document.getElementById('cl_total_debt_burden1').value = total_debt_burden.toLocaleString()
	document.getElementById('cl_total_debt_burden2').value = total_debt_burden.toLocaleString()
	// Don't take fraction
	document.getElementById('monthly_installment_payment').value = Math.floor(total_debt_burden * 0.05).toLocaleString()
	// Don't take fraction
	document.getElementById('c_pay_in_installments_5_m_onw').value = Math.floor(total_debt_burden * 0.05).toLocaleString()
	document.getElementById('installment_payments_all1').value = ((total_debt_burden * 0.05) * 60).toLocaleString()
	document.getElementById('interest_all1').value = (total_debt_burden - (total_debt_burden * 0.05) * 60).toLocaleString()
	document.getElementById('interest_all2').value =  (total_debt_burden - installment_payments_all2).toLocaleString()
}

function calInstallment(){
	let debt_burden = document.getElementById('debt_burden').value || "0";
	debt_burden = toStringNumber(debt_burden)
	let installment = 900
	if(debt_burden >= 400000 && debt_burden <= 450000){
		installment = 3000 
	}else if(debt_burden >= 450001 && debt_burden <= 550000){
		installment = 6000
	}else if(debt_burden >= 550001 ){
		installment = 9000
	}
	document.getElementById('installment_of_100k_b').value = installment.toLocaleString()
}

function calInstallmentUnit(){
	let debt_burden = document.getElementById('debt_burden').value || "0";
	debt_burden = toStringNumber(debt_burden)
	// Don't take fraction
	let unit = Math.floor(debt_burden / 100000)
	document.getElementById('calculated_per_unit_100k').value = unit.toLocaleString()
	calInstallmentPerUnit()
}

function calInstallmentPerUnit(){
	let installment_of_100k_b = document.getElementById('installment_of_100k_b').value || "0";
	installment_of_100k_b = toStringNumber(installment_of_100k_b)
	let original_interest = document.getElementById('original_interest').value || "0";
	original_interest = toStringNumber(original_interest)
	let calculated_per_unit_100k = document.getElementById('calculated_per_unit_100k').value || "0";
	calculated_per_unit_100k = toStringNumber(calculated_per_unit_100k)

	let perUnit = calculated_per_unit_100k * installment_of_100k_b
	document.getElementById('principle').value = perUnit.toLocaleString()

	let customerPay = original_interest + perUnit
	document.getElementById('c_pay_in_installments_first_4_m').value = customerPay.toLocaleString()
}
function calOriginalInterest(){
	let debt_burden = document.getElementById('debt_burden').value || "0";
	debt_burden = toStringNumber(debt_burden)
	let principle = document.getElementById('principle').value || "0";
	principle = toStringNumber(principle)
	let net_outstanding_debt = document.getElementById('net_outstanding_debt').value || "0";
	net_outstanding_debt = toStringNumber(net_outstanding_debt)
	// Don't take fraction
	let  originalInterest = Math.floor((debt_burden * 0.1834) / 12)
	document.getElementById('original_interest').value = originalInterest.toLocaleString()

	// Start ยังแก้ไม่ได้
	let  detail_net_outstanding_debt = (net_outstanding_debt / 60).toLocaleString()
	document.getElementById('total_original_installment_amount3').value = (originalInterest - detail_net_outstanding_debt).toLocaleString()
	// End ยังแก้ไม่ได้

	document.getElementById('installment_payments_all3').value = (originalInterest * 60).toLocaleString()
	
	let customerPay = originalInterest + principle
	document.getElementById('c_pay_in_installments_first_4_m').value = customerPay.toLocaleString()
}


document.getElementById('debt_burden').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	let base_salary = document.getElementById('base_salary').value || "0";
	base_salary = toStringNumber(base_salary)
	let debt_burden = document.getElementById('debt_burden').value || "0";
	debt_burden = toStringNumber(debt_burden)
	let Returns = '4%'
	if(base_salary >= 30000 && debt_burden <= 600000){
		Returns = '5%'
	}
	document.getElementById('Returns').value = Returns
	let return_percent = toStringNumber(Returns.replace('%', ''))
	
	let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')

	let rooms_ltvs = document.querySelectorAll(".room-ltv");
	rooms_ltvs.forEach(function (rooms_ltvs, index) {
		
		let rooms_ltv = getValue('room_LTV_' + index)
		// total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
		total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
		console.log('total_can_be_borrowed', total_can_be_borrowed)
		setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
	});

	calTotalDebt()
	calInstallment()
	calInstallmentUnit()
	calOriginalInterest()
})

document.getElementById('car_debt_n').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	calTotalDebt()
})
document.getElementById('car_debt_y').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	calTotalDebt()
})
document.getElementById('base_salary').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	let base_salary = document.getElementById('base_salary').value || "0";
	base_salary = toStringNumber(base_salary)
	let debt_burden = document.getElementById('debt_burden').value || "0";
	debt_burden = toStringNumber(debt_burden)
	let Returns = '4%'
	if(base_salary >= 30000 && debt_burden <= 600000){
		Returns = '5%'
	}
	document.getElementById('Returns').value = Returns
	let return_percent = toStringNumber(Returns.replace('%', ''))
	
	let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')

	let rooms_ltvs = document.querySelectorAll(".room-ltv");
	rooms_ltvs.forEach(function (rooms_ltvs, index) {
		
		let rooms_ltv = getValue('room_LTV_' + index)
		// total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
		total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
		console.log('total_can_be_borrowed', total_can_be_borrowed)
		setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
	});
})

function calNetIncome(){
	let age = document.getElementById('age').value || "0";
	age = toStringNumber(age)
	let net_income = document.getElementById('net_income').value || "0";
	net_income = toStringNumber(net_income)
	document.getElementById('approval_closed_20_times').value = (net_income * 20).toLocaleString()

	let totalNetPercent = 0.6
	if(net_income >= 30000 && age <= 40){
		totalNetPercent = 0.7
	}

	// Don't take fraction
	const totalNet =  mathCeil(parseInt( net_income * totalNetPercent ) / 7000 * 1000000, 10000)
	document.getElementById('Pre_borrow_amount_that_can_be_borrowed').value = totalNet.toLocaleString()

	let rooms_ltvs = document.querySelectorAll(".room-ltv");
	rooms_ltvs.forEach(function (rooms_ltvs, index) {
		
		let rooms_ltv = getValue('room_LTV_' + index)
		// total_can_be_borrowed = (Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)) * (return_percent / 100)
		let total_can_be_borrowed = totalNet * (rooms_ltv / 100)
		console.log('total_can_be_borrowed', total_can_be_borrowed)
		setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
	});
}
document.getElementById('age').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	calNetIncome()
})
document.getElementById('net_income').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	
	calNetIncome()
})

function calCustomerPay(){
	let installment_installments_with_company = document.getElementById('installment_installments_with_company').value || "0";
	installment_installments_with_company = toStringNumber(installment_installments_with_company)

	let principle = document.getElementById('principle').value || "0";
	principle = toStringNumber(principle)
	let original_interest = document.getElementById('original_interest').value || "0";
	original_interest = toStringNumber(original_interest)
	let total_debt_burden = document.getElementById('total_debt_burden').value || "0";
	total_debt_burden = toStringNumber(total_debt_burden)
	let c_pay_in_installments_5_m_onw = document.getElementById('c_pay_in_installments_5_m_onw').value || "0";
	c_pay_in_installments_5_m_onw = toStringNumber(c_pay_in_installments_5_m_onw)
	
	let  installmentsCompany4 = principle * 4
	let  installmentsCompany5 = c_pay_in_installments_5_m_onw - original_interest
	let  installmentsCompany5All = installmentsCompany5 + installmentsCompany4
	let net_outstanding_debt = 0
	if(installment_installments_with_company == 4){
		document.getElementById('installments_with_the_company_all').value = installmentsCompany4.toLocaleString()
		net_outstanding_debt = total_debt_burden - installmentsCompany4
	}else if(installment_installments_with_company == 5){
		document.getElementById('installments_with_the_company_all').value = installmentsCompany5All.toLocaleString()
		net_outstanding_debt = total_debt_burden - installmentsCompany5All
	}
	document.getElementById('net_outstanding_debt').value = net_outstanding_debt.toLocaleString()
	document.getElementById('cl_total_debt_burden3').value = net_outstanding_debt.toLocaleString()
}

document.getElementById('installment_installments_with_company').addEventListener("input",(event) => {
	event.target.value = onChangeNumber(event.target.value)
	calCustomerPay()
})

function calRoom(){
	let rooms_ltvs = document.querySelectorAll(".room-ltv");
	console.log("🚀 ~ calRoom ~ rooms_ltvs:", rooms_ltvs)
	let rooms_amount_that_can_bes = document.querySelectorAll(".room-amount-that-can-be");
	let rooms_room_property_development_costs = document.querySelectorAll(".room-property-development-costs");
 
	rooms_ltvs.forEach((el,index) => {
		console.log("🚀 ~ rooms_ltvs.forEach ~ el:", el)
		el.value = '100'
		el.addEventListener("input",(event) => {
			let Pre_borrow_amount_that_can_be_borrowed = getValue('Pre_borrow_amount_that_can_be_borrowed')
			event.target.value = onChangeNumber(event.target.value)
			let rooms_ltv = getValue('room_LTV_' + index)
			console.log("🚀 ~ el.addEventListener ~ rooms_ltv:", rooms_ltv)
			let total_can_be_borrowed = Pre_borrow_amount_that_can_be_borrowed * (rooms_ltv / 100)
			console.log("🚀 ~ el.addEventListener ~ total_can_be_borrowed:", total_can_be_borrowed)
			setValue('room_amount_that_can_be_' + index, total_can_be_borrowed)
			console.log("🚀 ~ el.addEventListener ~ total_can_be_borrowed:", total_can_be_borrowed)
		})
	})
	// for (const rooms_amount_that_can_be of rooms_amount_that_can_bes) {
	// 	rooms_amount_that_can_be.value = '100'
	// }
	// for (const rooms_room_property_development_cost of rooms_room_property_development_costs) {
	// 	rooms_room_property_development_cost.value = '100'
	// }
}
calRoom()

let net_property_development_cost             //  ค่าพัฒนาทรัพย์สุทธิ
let remaining_property_development_costs    //ค่าพัฒนาทรัพย์คงเหลือ
let net_outstanding_debt_mrta               // หนี้คงเหลือสุทธิ_mrta

let room_LTV_1                               // LTV
let room_LTV_2
let room_LTV_3
let room_LTV_4
let room_LTV_5
let room_LTV_6
let room_LTV_7
let room_LTV_8
let room_LTV_9

let room_amount_that_can_be_1                // วงเงินที่กู้ได้
let room_amount_that_can_be_2
let room_amount_that_can_be_3
let room_amount_that_can_be_4
let room_amount_that_can_be_5
let room_amount_that_can_be_6
let room_amount_that_can_be_7
let room_amount_that_can_be_8
let room_amount_that_can_be_9

let room_property_development_costs_1                // ค่าพัฒนาทรัพย์
let room_property_development_costs_2
let room_property_development_costs_3
let room_property_development_costs_4
let room_property_development_costs_5
let room_property_development_costs_6
let room_property_development_costs_7
let room_property_development_costs_8
let room_property_development_costs_9

// cl_total_debt_burden3            // หัวข้อ ยอดที่ต้องชำระ

// ช่อง1 ภาระหนี้ - ค่างวดผ่อน(ทั้งหมด)
// cl_total_debt_burden1 - installment_payments_all1 = interest_all1
// ช่อง2 ภาระหนี้ - ค่างวดผ่อน(ทั้งหมด)
// cl_total_debt_burden2 - installment_payments_all2 = interest_all2

let age                                               //อายุ
let net_income                                        //รายได้สุทธิ
let Pre_borrow_amount_that_can_be_borrowed            //พรีวงเงินที่สามารถกู้ได้

let installment_installments_with_company         //งวดผ่อนกับทางบริษัท
let original_interest                                   //ดอกเบี้ยของเดิม
let principle                                           //ผ่อนเงินต้นช่วงแรก



let c_pay_in_installments_first_4_m      //ลูกค้าผ่อนจ่าย (4 เดือนแรก)
let c_pay_in_installments_5_m_onw     //ลูกค้าผ่อนจ่าย (เดือนที่ 5 เป็นต้นไป)
let monthly_installment_payment                         //ค่างวดผ่อนต่อเดือน

let installments_with_the_company_all                 //ผ่อนกับทางบริษัท (ทั้งสิ้น)
let total_debt_burden                         //ภาระหนี้รวม
let net_outstanding_debt                         //หนี้คงเหลือสุทธิ
let approval_closed_20_times                          //อนุมัติปิด 20 เท่า


</script>
