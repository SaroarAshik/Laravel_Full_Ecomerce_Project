<div class="card" style="width: 18rem;">
    <img class="card-img-top"  style="border-radius: 50%;"
     src="{{ asset(Auth::user()->image) }}"  height="100%;"
      width="100%;" alt="Card image cap">

    <ul class="list-group list-group-flush">
          <a href="#" class="btn btn-primary btn-sm btn-block">Home</a>
          <a href="#" class="btn btn-primary btn-sm btn-block">My Orders</a>
          <a href="#" class="btn btn-primary btn-sm btn-block">Return Orders</a>
          <a href="#" class="btn btn-primary btn-sm btn-block">Cancel Orders</a>
          <a href="{{ route('user-image') }}" class="btn btn-primary btn-sm btn-block">Update Image</a>
          <a href="{{ route('update-password') }}" class="btn btn-primary btn-sm btn-block">Update Password</a>
          <a href="#" class="btn btn-primary btn-sm btn-block">Chats</a>
          <a href="#" class="btn btn-danger btn-sm btn-block"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                Log Out
          </a>
    </ul>
</div>
