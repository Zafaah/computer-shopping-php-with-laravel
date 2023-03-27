 <div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.html">
				{{-- <img src="vendors/images/deskapp-logo.svg" alt="" class="dark-logo"> --}}
				{{-- <img src="vendors/images/deskapp-logo-white.svg" alt="" class="light-logo"> --}}
				<h5 class="micon text-white">
					COMPUTER CHIP
				</h5>
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					@auth
						@foreach (session()->get('menus') as $menu)
							<li>
								<a href="{{$menu->link}}" class="dropdown-toggle no-arrow">
									<span class="micon {{$menu->icon}}"></span>
									<span class="mtext">{{$menu->menu_name}}</span>
								</a>
							</li>
						@endforeach
					@endauth
				</ul>
			</div>
		</div>
	</div>