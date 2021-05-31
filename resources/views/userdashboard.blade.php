User Has logged in
<br>
<br>
<br>


<a class="nav-link" href="{{ route('logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    <i class="menu-icon typcn typcn-user-outline"></i>
    <span class="menu-title">Logout</span>
</a>
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
