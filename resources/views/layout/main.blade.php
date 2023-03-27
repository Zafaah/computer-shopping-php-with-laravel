<!DOCTYPE html>
<html>

{{-- including head --}}
@include('components.head')

<body>
	{{-- including navigation and sidebar --}}
	@include('components.navigation')
	@include('components.sidebar')

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div style="min-height: 100vh;">
        @yield ('body')
      </div>
    </div>
  </div>
 

	{{-- including footer --}}
	@include('components.footer')
</body>

</html>