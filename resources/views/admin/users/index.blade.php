@extends('layouts.app')

@section('content')

<div style="max-width:1100px;margin:30px auto;padding:20px;">

    <h1>👥 Kelola User</h1>
    <p style="color:#666;">Daftar pengguna Galaxy Books.</p>

    <div style="background:white;padding:20px;border-radius:15px;box-shadow:0 5px 20px rgba(0,0,0,.08);overflow-x:auto;">

        @php
            $users = \App\Models\User::orderBy('id','desc')->get();
        @endphp

        <table style="width:100%;border-collapse:collapse;">

            <thead>
                <tr style="background:#f1f5f9;">
                    <th style="padding:12px;text-align:left;">ID</th>
                    <th style="padding:12px;text-align:left;">Nama</th>
                    <th style="padding:12px;text-align:left;">Email</th>
                    <th style="padding:12px;text-align:left;">Role</th>
                </tr>
            </thead>

            <tbody>

                @forelse($users as $user)

                <tr style="border-bottom:1px solid #eee;">

                    <td style="padding:12px;">
                        {{ $user->id }}
                    </td>

                    <td style="padding:12px;">
                        {{ $user->name }}
                    </td>

                    <td style="padding:12px;">
                        {{ $user->email }}
                    </td>

                    <td style="padding:12px;">

                        @if($user->is_admin)

                            <span style="background:#fef3c7;color:#92400e;padding:6px 10px;border-radius:20px;font-weight:bold;">
                                👑 Admin
                            </span>

                        @else

                            <span style="background:#dcfce7;color:#166534;padding:6px 10px;border-radius:20px;">
                                👤 User
                            </span>

                        @endif

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="4" style="padding:20px;text-align:center;">
                        Belum ada user.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection