<?php

class Menu extends BaseModel {

	protected $table = 'menus';

	protected $rules = array(
			'name' 		=> 'required',
			'parent_id' => 'integer',
			'order_no' 	=> 'integer',
			'active' 	=> 'integer',
		);

	public function productCategory()
	{
		return $this->hasOne('ProductCategory');
	}

	public function page()
	{
		return $this->hasOne('Page');
	}

	public static function get($arr = [])
	{
		if( isset($arr['parent']) ) {
			return self::getParent($arr);
		}
		if( isset($arr['header']) ) {
			return self::getFrontendHeader($arr);
		}
		if( isset($arr['footer']) ) {
			return self::getFrontendFooter($arr);
		}
		if( isset($arr['sidebar']) ) {
			return self::getSidebar();
		}
		return self::getMenu($arr);
	}

	private static function setMenu($menu)
	{
		$arrMenu = [];
		foreach($menu as $value){
			$arrMenu[$value['parent_id']][$value['id']]=$value;
		}
		return $arrMenu;
	}

	public static function getFrontendHeader()
	{
		$arrMenu = self::select('id', 'name', 'link', 'parent_id')
				->where('type', 'frontend')
				->where('group', 'header')
				->where('active', 1)
				->orderBy('parent_id','asc')
				->orderBy('order_no', 'asc')
				->orderBy('name', 'asc')
				->get();
		if( $arrMenu->isEmpty() ) {
			return [];
		}
		$arrMenu = self::setMenu($arrMenu->toArray());
		return self::renderHeaderMenu($arrMenu);
	}

	public static function getFrontendFooter()
	{
		$arrMenu = self::select('id', 'name', 'link', 'parent_id')
				->where('type', 'frontend')
				->where('group', 'footer')
				->where('active', 1)
				->orderBy('parent_id','asc')
				->orderBy('order_no', 'asc')
				->orderBy('name', 'asc')
				->get();
		if( $arrMenu->isEmpty() ) {
			return '';
		}
		$arrMenu = self::setMenu($arrMenu->toArray());
		return self::renderFooterMenu($arrMenu);
	}

	public static function getSidebar()
	{
		$arrMenu = self::select('id','name', 'icon_class', 'link', 'type', 'parent_id')
							->where('active', 1)
							->where('type', 'backend')
							->orderBy('parent_id','asc')
							->orderBy('order_no','asc')
							->orderBy('name','asc')
							->get();
		if( $arrMenu->isEmpty() ) {
			return '';
		}
		$arrMenu = self::setMenu($arrMenu->toArray());
		return self::renderSidebar($arrMenu);
	}

	public static function getMenu($arr)
	{
		$arrMenu = self::select('id','name','icon_class','link','type', 'parent_id','group', 'order_no','level', 'active');
		if( !isset($arr['active']) || $arr['active'] ) {
			$arrMenu->where('active', 1);
		}
		$arrMenu = $arrMenu->orderBy('parent_id','asc')
							->orderBy('order_no','asc')
							->orderBy('name','asc')
							->get();
		if( $arrMenu->isEmpty() ) {
			return '';
		}
		$arrMenu = self::setMenu($arrMenu->toArray());
	    $admin = Auth::admin()->get();
	    $permission = new Permission;
		$arrPermission = [
							'frontend' => [
								'view' => $permission->can($admin, 'menusfrontend_view_all'),
								'edit' => $permission->can($admin, 'menusfrontend_edit_all'),
								'delete' => $permission->can($admin, 'menusfrontend_delete_all'),
							],
							'backend' => [
								'view' => $permission->can($admin, 'menusbackend_view_all'),
								'edit' => $permission->can($admin, 'menusbackend_edit_all'),
								'delete' => $permission->can($admin, 'menusbackend_delete_all'),
							]
						];

		return self::renderMenu($arrMenu, $arrPermission);
	}

	public static function getParent($arrCondition = [])
	{
		$arrMenu = self::select('id', 'name', 'parent_id', 'level', 'type')
						->where('active', '=', 1)
						->where('level', '<', 5);
		if( isset($arrCondition['id']) ) {
			$arrMenu->where('id', '<>', $arrCondition['id']);
		}
		if( isset($arrCondition['type']) ) {
			$arrMenu->where('type', $type);
		}
		$arrMenu = $arrMenu->orderBy('order_no','asc')
						->orderBy('name','asc')
						->get();
		if( $arrMenu->isEmpty() ) {
			return '';
		}
		$arrMenu = self::setMenu($arrMenu->toArray());
		return self::renderParent($arrMenu);
	}

	private static function renderHeaderMenu(&$arrMenu, $parent_id = 0, $arrHTML = array())
	{
		if( isset($arrMenu[$parent_id]) ){
			if( !isset($arrHTML['default']) ) {
				$arrHTML['default'] = '';
			}
			if( !isset($arrHTML['mobile']) ) {
				$arrHTML['mobile'] = '';
			}
			foreach($arrMenu[$parent_id] as $k => $menu){
				$id = $menu['id'];
				if ( isset($arrMenu[$id]) ) {
					$children = self::renderHeaderMenu($arrMenu, $id);
					$arrHTML['default'] .= '<li class="nav-item dropdown">
												<a class="nav-item-link" href="#" title="'. $menu['name'] .'" style="cursor:pointer;">
				                						'. $menu['name'] .'
				                                    <span aria-hidden="true" class="glyph arrow-down"></span>
					                            </a>
					                            <ul class="sub-nav catalog">
					                            	'. $children['default'] .'
					                            </ul>
											</li>';
					$arrHTML['mobile'] .= '<li class="nav-item dropdown">
				                            <a class="dropdown-link" href="#">
				                            	'. $menu['name'] .'
					                            <span aria-hidden="true" class="glyph plus"></span>
					                            <span aria-hidden="true" class="glyph minus"></span>
				                            </a>
				                            <ul class="sub-nav catalog">
				                                <li class="bg"></li>
				                                '. $children['mobile'] .'
				                            </ul>
					                    </li>';
				} else {
					if( $parent_id ) {
						$arrHTML['default'] .= '
												<li class="sub-nav-item row">
													<div class="collections columns large-3">
														<h3 class="title">
				                                            <a href="'.URL.'/'. $menu['link'] .'" title="'. $menu['name'] .'">
				                                                '. $menu['name'] .'
				                                            </a>
			                                            </h3>
			                                        </div>
			                                    </li>';
					} else {
						$arrHTML['default'] .= '<li class="nav-item ">
						                            <a class="nav-item-link" href="'. URL .'/'. $menu['link'] .'" title="'. $menu['name'] .'" style="cursor:pointer;">
						                            '. $menu['name'] .'
						                            </a>
						                        </li>';
					}

					$arrHTML['mobile'] .= '<li class="nav-item ">
					                            <a class="nav-item-link" href="'. URL .'/'. $menu['link'] .'" title="'. $menu['name'] .'">
					                            '. $menu['name'] .'
					                            </a>
					                        </li>';
				}
				unset($arrMenu[$parent_id][$k]);
			}

		}
		return $arrHTML;
	}

	private static function renderFooterMenu(&$arrMenu, $parent_id = 0, $html = '')
	{
		if( isset($arrMenu[$parent_id]) ){
			$i = 1;
			foreach($arrMenu[$parent_id] as $k => $menu){
				$id = $menu['id'];
				if ( isset($arrMenu[$id]) ) {
					$html .= '<div class="column-'. $i.' large-3 columns">
								<h2 class="title">'. $menu['name'] .'</h2>
								<div class="content">
									<ul class="footer-nav plain-list" role="navigation">'
										. self::renderFooterMenu($arrMenu, $id) .
									'</ul>
								</div>
							</div>';
				} else {
					if( $parent_id ) {
						$html .= '<li>
									<a href="'.URL.'/'. $menu['link'] .'" title="'. $menu['name'] .'" style="text-transform:uppercase;">'. $menu['name'] .'</a>
								</li>';
					} else {
						$html .= '<div class="column-'. $i .' large-3 columns">
									<h2 class="title"><a href="'. $menu['name'] .'" title="'. $menu['name'] .'" /></h2>
								</div>';
					}
				}
				unset($arrMenu[$parent_id][$k]);
				$i++;
			}

		}
		return $html;
	}

	private static function renderSidebar($arrMenu, $parent_id = 0, $html = '')
	{
		if( isset($arrMenu[$parent_id]) ){
			foreach($arrMenu[$parent_id] as $k => $menu){
				$id = $menu['id'];
				if ( isset($arrMenu[$id]) ) {
					$html .= '<li>
								<a href="javascript:void(0)">
									<i class="'.$menu['icon_class'].'"></i>
									<span class="title">'.$menu['name'].'</span>
									<span class="arrow "></span>
								</a>
								<ul class="sub-menu">
								'. self::renderSidebar($arrMenu, $id) .'
								</ul>
							</li>';
				} else {
					$html .= '<li>
								<a href="'.URL.'/'.$menu['link'].'">
									<i class="'.$menu['icon_class'].'"></i>
									<span class="title">'.$menu['name'].'</span>
								</a>
							</li>';;
				}
				unset($arrMenu[$parent_id][$k]);
			}
		}
		return $html;
	}

	private static function renderMenu(&$arrMenu, $arrPermission, $parent_id = 0, $arrHTML = array())
	{
		if( isset($arrMenu[$parent_id]) ){
			foreach($arrMenu[$parent_id] as $k => $menu){
				if( !$arrPermission[$menu['type']]['view'] ) {
					continue;
				}
				$key = $menu['type'];
				if( !empty($menu['group']) ) {
					$key .= '-'.$menu['group'];
				}
				if( !isset($arrHTML[$key]) ) {
					$arrHTML[$key] = '';
				}
				$id = $menu['id'];
				$style = $disable = $delete = '';
				if( !$menu['active'] ) {
					$style = 'style="background-color: #ccc"';
				}
				if( $arrPermission[$menu['type']]['delete'] ) {
					$delete = '<span class="pull-right">
		                            <a data-function="delete" href="javascript:void(0)"  onclick="deleteMenu('. $menu['id'] .')">
		                                <i class="fa fa-times"></i>
		                            </a>
		                        </span>';
				}
				if( !$arrPermission[$menu['type']]['edit'] ) {
					$disable = 'disabled-link';
				}
				$arrHTML[$key] .= '<li class="dd-item dd3-item" data-id="'. $menu['id'] .'">
									<div class="dd-handle dd3-handle">
									</div>
									<div class="dd3-content '. $disable .'" '. $style .'data-id="'.$menu['id'].'">
										'. $menu['name'] .'
										<input type="hidden" id="menu-'. $menu['id'] .'" value="' .e(json_encode($menu)) .'" />
										'. $delete .'
									</div>';
				if ( isset($arrMenu[$id]) ) {
					$data = self::renderMenu($arrMenu,  $arrPermission, $id);
					$arrHTML[$key] .=   '<ol class="dd-list">
										'. $data[$key] .'
										</ol>';
				}
				$arrHTML[$key] .= '</li>';
				unset($arrMenu[$parent_id][$k]);
			}
		}
		return $arrHTML;
	}

	private static function renderParent($arrMenu, $parent_id = 0, $arrHTML = array())
	{
		if( isset($arrMenu[$parent_id]) ){
			foreach($arrMenu[$parent_id] as $k => $menu) {
				$type = $menu['type'];
				if( !isset($arrHTML[$type]) ) {
					$arrHTML[$type] = [];
				}
				$prefix = '';
				if( $parent_id ) {
					for($i = 1; $i < $menu['level']; $i++) {
						$prefix .= '--';
					}
				}
				$id = $menu['id'];
				if( isset($arrMenu[$id]) ) {
					$arrHTML[$type][] = '<option value="'. $menu['id'] .'">'. $prefix.$menu['name'] .'</option>';
					if( $type == 'frontend' ) continue;
					$arrHTML = self::renderParent($arrMenu, $id, $arrHTML);
				} else {
					$arrHTML[$type][] = '<option value="'. $menu['id'] .'">'. $prefix.$menu['name'] .'</option>';
				}
			}
		}
		return $arrHTML;
	}

	public static function getCache($arrCondition = [])
	{
		$cacheKey = md5(serialize($arrCondition));
		if( isset($arrCondition['frontend']) ) {
			$cacheManager = Cache::tags('menu', 'frontend');
		} else if( isset($arrCondition['backend']) ) {
			$cacheManager = Cache::tags('menu', 'backend');
		} else {
			$cacheManager = Cache::tags('menu');
		}
		if( $cacheManager->has('menu_'.$cacheKey) ) {
			$cache = $cacheManager->get('menu_'.$cacheKey);
		} else {
			$cache = Menu::get($arrCondition);
			$cacheManager->forever('menu_'.$cacheKey, $cache);
		}
		return $cache;
	}

	public static function updateMenu($page, $action, $prefixLink = '')
   	{
		if( $action == 'add' ) {
			if( $page->menu_id ) {
				$menu = Menu::find($page->menu_id);
				if( !is_object($menu) ) {
					$page->menu_id = 0;
				}
			}

			if( !$page->menu_id ) {
				$menu = new Menu;
				$menu->name = $page->name;
				$menu->icon_class = '';
				$menu->parent_id = 0;
				$menu->type = 'frontend';
				$menu->group = 'header';
				$menu->order_no = 1;
				$menu->level = 1;
				$menu->active = 1;
			}
			$menu->active = $page->active;
			$menu->link = $prefixLink . $page->short_name;
			$menu->save();
			$page->menu_id = $menu->id;
		} else if( $action == 'delete' ) {
			if( $page->menu_id ) {
				self::destroy($page->menu_id);
				$page->menu_id = 0;
			}
		}
		return $page;
   	}

	public static function updateRecursiveChildOrder($arrMenu, $parentID, $i)
	{
		if( $parentID )
			$parentID = $parentID;
		foreach($arrMenu as $key => $value){
			if( isset($value->children) ) {
				self::updateRecursiveChildOrder($value->children, $value->id, $i+1);
			}
			Menu::where('id', $value->id)
						->update([
								'parent_id' => 	$parentID,
								'order_no' 	=>	($key+1),
								'level' 	=>	$i,
							]);
		}
	}

	public static function updateRecursive($parentID, $arrData)
	{
		$arrMenu = Menu::select('id')
							->where('parent_id', $parentID)
							->get();
		if( !$arrMenu->isEmpty() ) {
			foreach($arrMenu as $menu) {
				self::updateRecursive($menu->id, $arrData);
			}
		}
		Menu::where('parent_id', $parentID)
				->update($arrData);
	}

	public static function clearCache()
	{
		Cache::tags('menu')->flush();
		Cache::tags('menu', 'frontend')->flush();
		Cache::tags('menu', 'backend')->flush();
	}

	public function afterSave($menu)
	{
		return Cache::tags('menu')->flush();
	}

	public function beforeDelete($menu)
	{
		$menu->page()->update(['menu_id' => 0]);
		Cache::tags('menu')->flush();
		Cache::tags('menu', 'frontend')->flush();
		Cache::tags('menu', 'backend')->flush();
	}

}