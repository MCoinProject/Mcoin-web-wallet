<aside id="leftsidebar" class="sidebar">
    <!-- User Info -->
    <div class="user-info">
        <div class="image">
            <img src="{{ asset('/images/default_avatar.png') }}" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
            <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{-- Check if user have rofile name, if exist; display the name. If not then display string --}}
                {{isset(Auth::user()->profile->name) ? Auth::user()->profile->name : "Set Your Name"}}
            </div>
            <div class="email">{{ Auth::user()->email}}</div>
            <div class="btn-group user-helper-dropdown">
                <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                <ul class="dropdown-menu pull-right">
                    <li><a href="{{ URL::to('/profile') }}"><i class="material-icons">person</i>Profile</a></li>
                    <li role="seperator" class="divider"></li>
                    <li><a href="/logout"><i class="material-icons">input</i>Sign Out</a></li>
                </ul>
            </div>
        </div>
    </div>
    <!-- #User Info -->
    <!-- Menu -->
    <div class="menu">
        <ul class="list">
            <li class="header">MAIN NAVIGATION</li>
            <li class="{{ Request::is('wallet', 'wallet/*') ? 'active' : '' }}">
                <a href="/wallet">
                    <i class="material-icons">account_balance_wallet</i>
                    <span>Wallet</span>
                </a>
            </li>
            <li class="{{ Request::is('transactions', 'transactions/*') ? 'active' : '' }}">
                <a href="javascript:void(0);" class="menu-toggle">
                    <i class="material-icons">repeat</i>
                    <span>Transactions</span>
                </a>
                <ul class="ml-menu">
                    <li class="{{ Request::is('transactions/transfer') ? 'active' : '' }}">
                        <a href="{{ URL::to('/transactions/transfer') }}">
                            {{-- <i class="material-icons">call_made</i> --}}
                            <span>Transfer</span>
                        </a>
                    </li>
                    <li class="{{ Request::is('transactions/request') ? 'active' : '' }}">
                        <a href="{{ URL::to('/transactions/request') }}">
                            {{-- <i class="material-icons">call_received</i> --}}
                            <span>Request</span>
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <!-- #Menu -->
    <!-- Footer -->
    <div class="legal">
        <div class="copyright">
            &copy; {{date("Y")}} <a href="javascript:void(0);"> ETP Wallet</a>.
        </div>
        <div class="version">
            <b>Version: </b> 1.0.0
        </div>
    </div>
    <!-- #Footer -->
</aside>