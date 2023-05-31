$(document).ready(function () {
    $.ajaxSetup({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      },
    });
  
    $("form[request-ajax=LBD]").submit(function (e) {
      e.preventDefault();
      var form = $(this);
      var url = form.attr("action");
      var method = form.attr("method");
      var href = form.attr("href");
      var data = form.serialize();
      let button = form.find("button[type=submit]");
      var token = $('meta[name="csrf-token"]').attr("content");
      data += "&_token=" + token;
      if (button.attr("show")) {
        Swal.fire({
          title: "Bạn chắc chắn?",
          text: button.attr("show"),
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Đồng ý",
        }).then((result) => {
          if (result.isConfirmed) {
            formSubmit(url, method, href, data, button);
          }
        });
      } else {
        formSubmit(url, method, href, data, button);
      }
    });
  });
  
  function formSubmit(url, method, href, data, button) {
    var txtBtn = button.html().trim();
  
    let settings = {
      url,
      method,
      data,
      dataType: "json",
      beforeSend: function () {
        button
          .prop("disabled", true)
          .html(`<i class="fa fa-spinner fa-spin"></i> Đang xử lý...`);
      },
      complete: function () {
        button.prop("disabled", false).html(txtBtn);
      },
      success: function (response) {
        if (button.attr("callback")) {
          window[`${button.attr("callback")}`](response);
        }
        if (!button.attr("callback")) {
          //Swal(response.message, response.status === true ? "success" : "error");
          Swal.fire(
            "Thông báo",
            response.message,
            response.status === true ? "success" : "error"
          );
        }
        if (
          response.status === true &&
          !button.attr("href") &&
          !button.attr("callback")
        ) {
          setTimeout(() => {
            if (!href) {
              location.reload();
              return;
            }
            location.href = href;
          }, 2000);
        }
      },
      error: function (error) {
        console.log(error);
      },
    };
    $.ajax(settings);
  }
  