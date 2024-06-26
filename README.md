# DEALIFY
​
## Group ltw13g02
​
- Filipa Fidalgo (up202208039) 33.3%
- Leonor Couto (up202205796) 33.3%
- Pedro Oliveira (up202206498) 33.3%
​
## Install Instructions
​​

    git clone https://github.com/FEUP-LTW-2024/

    ltw-project-2024-ltw13g02.git

    git checkout final-delivery-v1

    sqlite database/database.db < database/database.sql
    php -S localhost:9000
​
## External Libraries
​
 - Google Fonts (https://fonts.google.com/), used to get font for our website
 - Font Awesome (https://fontawesome.com/v4/icons/), used to get icons for our website
​
## Screenshots
​
![mainPage](./prints/mainPage.png)
![productPage](./prints/productPage.png)
![personalInfo](./prints/personalInfo.png)
![messagesPage](./prints/messagesPage.png)
​
## Implemented Features
​
*General*:
​
- [x] Register a new account.
- [x] Log in and out.
- [x] Edit their profile, including their name, username, password, and email.

​
*Sellers*  should be able to:
​

- [x] List new items, providing details such as category, brand, model, size, and condition, along with images.
- [x] Track and manage their listed items.
- [x] Respond to inquiries from buyers regarding their items and add further information if needed.
- [x] Print shipping forms for items that have been sold.
​

*Buyers*  should be able to:
​

- [x] Browse items using filters like category, price, and condition.
- [x] Engage with sellers to ask questions or negotiate prices.
- [x] Add items to a wishlist or shopping cart.
- [x] Proceed to checkout with their shopping cart (simulate payment process).
​

*Admins*  should be able to:
​

- [x] Elevate a user to admin status.
- [x] Introduce new item categories, sizes, conditions, and other pertinent entities.
- [x] Oversee and ensure the smooth operation of the entire system.
​

*Security*:
We have been careful with the following security aspects:
​

- [x] *SQL injection*
- [x] *Cross-Site Scripting (XSS)*
- [x] *Cross-Site Request Forgery (CSRF)*
​

*Password Storage Mechanism*: hash_password&verify_password
​

*Aditional Requirements*:
​​

- [x] *Rating and Review System*
- [ ] *Promotional Features*
- [ ] *Analytics Dashboard*
- [ ] *Multi-Currency Support*
- [ ] *Item Swapping*
- [x] *API Integration*
- [ ] *Dynamic Promotions*
- [x] *User Preferences*
- [x] *Shipping Costs*
- [ ] *Real-Time Messaging System*