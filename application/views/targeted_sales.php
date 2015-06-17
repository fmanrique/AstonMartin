<?php setlocale(LC_MONETARY, 'en_US'); ?>
<div class="row">
	<div class="col-md-12 mb20">
		<h2>Quarterly Targeted Sales</h2>
	</div>
	<!--=== Static Table ===-->
	<div class="col-md-6">
		<?php for ($i = 1; $i<=4; $i++): ?>
		<div class="col-md-6">
			<div class="widget box">
				<div class="widget-header">
					<h4><i class="icon-calendar"></i> Q<?php echo $i; ?></h4>
				</div>
				<div class="widget-content no-padding">
					<table class="table no-order" id="audiences">
						<thead>
							<tr>
								<th class="no-sort" style="width: 50%">Month</th>
								<th class="no-sort">Sales</th>
							</tr>
						</thead>
						<tbody>	
						<?php foreach($data['q'.$i] as $key => $quarter) {?>
							</tr>
								<td style="position: relative; top: 6px; height: 49px"><?php echo $quarter['month']; ?></td>
								<?php if ($dealership_id != 0): ?>
								<td><input type="text" data-id="<?php echo $quarter['sales_id']; ?>" data-month="<?php echo $quarter['month_id']; ?>" data-quarter="<?php echo $quarter['quarter']; ?>" id="sales<?php echo $quarter['month_id'] ?>" class="form-control required" value="<?php echo $quarter['sales']; ?>" maxlength="6"></td>
								<?php else: ?>
								<td style="position: relative; top: 6px; height: 49px"><?php echo $quarter['sales']; ?></td>
								<?php endif; ?>
							</tr>
						<?php } ?>
						</tbody>
					</table>
				</div> <!-- /.widget-content -->
			</div> <!-- /.widget -->
		</div> <!-- /.col-md-6 -->
		<?php endfor; ?>
		
	</div> <!-- /.col-md-6 -->
	<div class="col-md-6 form-vertical no-margin">
		<div class="widget">
			<div class="widget-content">
				<div class="row mb30">
					<div class="col-md-7">
						<span class="control-label" style="font-size: 20px">Target: </span>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<span class="control-label" id="targeted"  data-amount="<?php echo $totals['targeted']; ?>"  style="font-size: 20px; white-space: nowrap"><?php echo $totals['targeted']; ?></span>
						</div>
					</div>
				</div>
				<div class="row mb30">
					<div class="col-md-7">
						<span class="control-label"  style="font-size: 20px">New Car Sales Revenue (Gross): </span>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<span class="control-label" id="gross" data-amount="<?php echo $totals['gross']; ?>" style="font-size: 20px; white-space: nowrap">$ <?php echo number_format($totals['gross'], '2'); ?></span>
						</div>
					</div>
				</div>
				<div class="row mb30">
					<div class="col-md-7">
						<span class="control-label" style="font-size: 20px">Marketing Spend @ 1.5%: </span>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<span class="control-label" id="marketing" data-amount="<?php echo $totals['marketing']; ?>" style="font-size: 20px; white-space: nowrap">$ <?php echo number_format($totals['marketing'], '2'); ?></span>
						</div>
					</div>
				</div>
				<div class="row mb30">
					<div class="col-md-7">
						<span class="control-label" style="font-size: 20px">Marketing Spend: </span>
					</div>

					<div class="col-md-5">
						<div class="form-group">
							<span class="control-label" id="spend" data-amount="<?php echo $totals['spend']; ?>" style="font-size: 20px; white-space: nowrap">$ <?php echo number_format($totals['spend'], '2'); ?></span>
						</div>
					</div>
				</div>
			</div> <!-- /.widget-content -->
		</div> <!-- /.widget -->
	</div> <!-- /.col-md-6 -->
	<!-- /Static Table -->
</div> <!-- /.row -->

<?php if ($dealership_id != 0): ?>
<script language="javascript">
$(document).ready(function() {
	$("input:text").on('keydown', function(e){
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
	}).change(function () {
		targeted = 0;
		if ($(this).val() == "") $(this).val("0");
		for (i = 1; i<=12; i++) {
			targeted += parseInt($('#sales'+i).val());
		}
		
		$('#targeted').data("amount", targeted);
		$('#targeted').html(targeted);

		$('#gross').data("amount", parseInt(targeted) * 200000);
		$('#gross').text('$ ' + parseFloat($('#gross').data("amount"), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

		$('#marketing').data("amount", parseInt($('#gross').data("amount")) * 0.015);
		$('#marketing').text('$ ' + parseFloat($('#marketing').data("amount"), 10).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,").toString());

		$.ajax({
			url: base_url + 'sales/save/'+$(this).data("id"),
			type: 'post',
			data: {sales: $(this).val(), month: $(this).data("month"), quarter: $(this).data("quarter")}
		});
		//alert($(this).data("month"));
		//alert(previous);
	})
});
</script>
<?php endif; ?>