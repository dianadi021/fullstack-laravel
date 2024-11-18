@extends('layouts.app')

@section('title', 'Laravel')

@section('root_container')
    <main class="w-full flex items-center justify-center h-screen">
        <div id="registerSection">
            @include('layouts.partials.register')
        </div>
        <div id="loginSection">
            @include('layouts.partials.login')
        </div>
    </main>

    <script>
        // ONLOAD START
        $(document).ready(function() {
            $("#loginSection").hide();
            // $("#registerSection").hide();
        })
        // ONLOAD END

        // FUNCTION ON CHECK START
        function errAlert($msg) {
            Swal.fire({
                title: "Gagal memproses!",
                text: $msg,
                icon: "warning",
                confirmButtonColor: "#3085d6",
            })
        }
        // FUNCTION ON CHECK END

        // FUNCTIONS START
        function submitForm($section) {
            event.preventDefault();
            $(".hide_notif").each(function() {
                $(this).hide();
            });

            if ($section == "registerForm") {
                if (!$("#company_name").val()) {
                    errAlert("Nama Klinik tidak boleh kosong!");
                    $("#company_name").focus();
                    return false;
                }

                if (!$("#provinsi").val()) {
                    errAlert("Provinsi tidak boleh kosong!");
                    $("#provinsi").focus();
                    return false;
                }

                if (!$("#kabupaten").val()) {
                    errAlert("Kabupaten tidak boleh kosong!");
                    $("#kabupaten").focus();
                    return false;
                }

                if (!$("#kecamatan").val()) {
                    errAlert("Kecamatan tidak boleh kosong!");
                    $("#kecamatan").focus();
                    return false;
                }

                // if (!$("#kelurahan").val()) {
                //     errAlert("Kelurahan tidak boleh kosong!");
                //     $("#kelurahan").focus();
                //     return false;
                // }
            }

            Swal.fire({
                title: "Apakah yakin ingin melanjutkan?",
                // text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                cancelButtonText: "Batal",
                confirmButtonText: "Lanjutkan"
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#clientRegist").show();

                    $("#_csrf-token").val($('meta[name="csrf-token"]').attr('content'));
                    $("#csrf-token").val($('meta[name="csrf-token"]').attr('content'));

                    $("#loadingAjax").show();
                    $(".hideBtnProcess").hide();
                    toastr.warning("Sedang diproses, mohon tunggu!", "Peringatan!");

                    if ($section == "registerForm") {
                        $.ajax({
                            url: `${$base_url}/api/users`,
                            type: "POST",
                            data: $("#registerForm").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                const { messages } = callback;
                                console.dir('success', callback);
                                toastr.success(messages, "Success!");

                                setTimeout(() => {
                                    LoginAjaxSection($("#registerForm").serializeArray(), $('meta[name="csrf-token"]').attr('content'));
                                }, 1500);
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, datas } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const { errorInfo: errInfo, validator: validCallback } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                if (errors) {
                                    for (let key in errors) {
                                        toastr.error(errors[key][0], "Kesalahan!");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const tmpMsg = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                    toastr.error(tmpMsg, "Kesalahan!");
                                }

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();

                                Swal.fire({
                                    title: "Kesalahan!",
                                    text: message || messages || errorInfo || validator,
                                    icon: "error"
                                }).then(function() {
                                    $("#clientRegist").hide();
                                    // window.location.reload();
                                });
                            },
                        });
                    }

                    if ($section == "loginForm") {
                        $.ajax({
                            url: `${$base_url}/login`,
                            type: "POST",
                            data: $("#loginForm").serializeArray(),
                            xhrFields: {
                                withCredentials: true
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(callback) {
                                console.dir('success', callback);
                                toastr.success('berhasil login!', "Success!");

                                setTimeout(() => {
                                    window.location.href = `${$base_url}/dashboard`;
                                }, 1500);
                            },
                            error: function(callback) {
                                const { responseJSON } = callback;
                                const { errors, message, messages, datas } = responseJSON;
                                let errorInfo, validator;
                                if (datas) {
                                    const { errorInfo: errInfo, validator: validCallback } = datas
                                    errorInfo = errInfo;
                                    validator = validCallback;
                                }
                                console.dir('error', callback);

                                if (errors) {
                                    for (let key in errors) {
                                        toastr.error(errors[key][0], "Kesalahan!");
                                        $(`#err_${key}`).show();
                                        $(`#err_${key} li`).html(errors[key][0]);
                                    }
                                } else if (message || messages || errorInfo || validator) {
                                    const tmpMsg = (validator ? "input data tidak sesuai atau tidak boleh kosong" : ( errorInfo ? errorInfo[2] : (messages ? messages : message)));
                                    toastr.error(tmpMsg, "Kesalahan!");
                                }

                                $("#loadingAjax").hide();
                                $(".hideBtnProcess").show();

                                Swal.fire({
                                    title: "Kesalahan!",
                                    text: message || messages || errorInfo || validator,
                                    icon: "error"
                                }).then(function() {
                                    // window.location.reload();
                                });
                            },
                        });
                    }
                }
            });
        }

        function openSection($section) {
            if ($section == "registerSection") {
                $("#loginSection").hide();
                $("#registerSection").show();
            }
            if ($section == "loginSection") {
                $("#registerSection").hide();
                $("#loginSection").show();
            }
        }
        // FUNCTIONS END
    </script>
@endsection
