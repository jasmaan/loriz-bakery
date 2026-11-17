# TODO

Known issues and planned work. Customer ordering works; most of this is the staff dashboard.

## Security
- [ ] Hash staff passwords. `lb_users.user_pass` is plain text; use `password_hash()` and `password_verify()`.
- [ ] Add `exit;` after the login redirects in `dashboard_sidebar.php` and `delete_product.php`.
- [ ] Check login in `add_product.php` before the insert runs.

## Bugs
- [ ] Delete product sends the name instead of `product_id`, and queries `id` instead of `product_id`.
- [ ] Order email is lost: checkout sends `customer_email`, `place_order.php` reads `email`.
- [ ] `order_success.php` is missing, but `place_order.php` redirects to it.
- [ ] Login shows no message on failure (it's commented out).
- [ ] `add_product.php` has a broken `<textarea>` tag and an unclosed `<form>`.
- [ ] `dashboard_sidebar.php` outputs a full HTML page inside pages that already have one.

## Features
- [ ] Email or text when an order is placed.
- [ ] Real data in the dashboard tiles (currently hard-coded).
- [ ] Edit-product form.
