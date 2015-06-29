<?php

class ProductsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('products')->delete();
        
		\DB::table('products')->insert(array (
			0 => 
			array (
				'id' => 74,
				'name' => 'ImageStylor Canvas',
				'short_name' => 'imagestylor-canvas',
				'sku' => 'IC-2043',
				'sell_price' => 0,
				'margin_up' => 0,
				'short_description' => '',
				'description' => '<p><span style="font-size:x-small;">The Imagestylor Canvas is the latest and most innovative product in our wall art decor line. It’s a canvas wrap like you’ve never seen before! The catch? It’s not canvas - it’s made from a rigid board with a canvas like texture. The waterproofing allows for outdoor usage giving the Imagestylor Canvas yet another advantage over a canvas wrap. Any shape with an edge can be made-to-order here. </span></p>

<p><span style="font-size:x-small;">Choose to wrap your entire image all the way around OR select a fun colour for some creative flare for the edges. The best feature about this product is the fast turn around time of only 2 working days!</span></p>
',
				'meta_title' => '',
				'meta_description' => '',
				'custom_size' => 1,
				'active' => 1,
				'order_no' => 1,
				'product_type_id' => 0,
				'default_view' => '["32","25","12"]',
				'svg_file' => 'assets/svg/13-03-15-03-03-47-12.svg',
				'svg_layout_id' => 0,
				'jt_id' => NULL,
				'created_by' => 8,
				'updated_by' => 3,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-06-19 09:24:23',
			),
			1 => 
			array (
				'id' => 96,
				'name' => 'Acrylic Photo',
				'short_name' => 'acrylic-photo',
				'sku' => 'is16x20',
				'sell_price' => 0,
				'margin_up' => 0,
				'short_description' => '',
				'description' => '<strong>ImageStyle</strong><span style="line-height:27.0399990081787px;"> is a custom framed photo print developed by <strong>Anvy Digital</strong>. This unique photo product combines a stylish frame system with a silky smooth finished print elegantly wrapped onto a rigid backing panel. ImageStyles color and finish are clean and spectacular, a sure fit for your home or office. With a variety of frame options available, ImageStyles vibrant prints are the perfect way to cherish your fond memories.</span>',
				'meta_title' => '',
				'meta_description' => '',
				'custom_size' => 1,
				'active' => 1,
				'order_no' => 0,
				'product_type_id' => 0,
				'default_view' => '["27","25"]',
				'svg_file' => 'assets/svg/drawing.svg',
				'svg_layout_id' => 0,
				'jt_id' => NULL,
				'created_by' => 8,
				'updated_by' => 3,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-06-19 09:24:07',
			),
			2 => 
			array (
				'id' => 187,
				'name' => 'Alloy Image Box',
				'short_name' => 'alloy-image-box',
				'sku' => 'WEB-818',
				'sell_price' => 0,
				'margin_up' => 0,
				'short_description' => '',
				'description' => '<span style="color:#3f3f3f;font-family:\'Open Sans\', Arial, Helvetica, sans-serif;font-size:14px;">This finished, 3D box is contour cut and folded using our patented Photo-Box™ cut-and-fold system, fashioning a ready-to-hang product. The self-framing, brushed finish of the Alloy Image Box makes a professional and refined statement. Whether your space longs for a moody black-and-white photo, or a crisp and professional business portrait, the Alloy Image Box is a brilliant solution. </span><span style="color:#3f3f3f;font-family:\'Open Sans\', Arial, Helvetica, sans-serif;font-size:14px;">Your high-definition photo is printed directly to aluminium, then a protective UV liquid coating is applied.  The printed metal sheet is mitre grooved and fabricated to create the finished Alloy Box, which is secured neatly to the wall with concealed keyhole fixings.</span>',
				'meta_title' => '',
				'meta_description' => '',
				'custom_size' => 1,
				'active' => 1,
				'order_no' => 1,
				'product_type_id' => 0,
				'default_view' => '["31","25","12"]',
				'svg_file' => NULL,
				'svg_layout_id' => 0,
				'jt_id' => NULL,
				'created_by' => 8,
				'updated_by' => 3,
				'created_at' => '0000-00-00 00:00:00',
				'updated_at' => '2015-06-19 09:23:49',
			),
		));
	}

}
