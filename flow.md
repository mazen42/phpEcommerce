/register → تسجيل يوزر عادي
/login → تسجيل دخول
/forgot-password → نسيت الباسورد

---

/ → Home (عرض منتجات)
/products → كل المنتجات
/products/{id} → تفاصيل منتج
/cart → السلة
/checkout → إتمام الشراء
/orders → طلباتي
/orders/{id} → تفاصيل طلب
/profile → بياناتي

---

/become-vendor → طلب تحويل لـ Vendor (مش Register جديد!)
/vendor/dashboard → إحصائيات
/vendor/products → منتجاتي
/vendor/products/create → إضافة منتج
/vendor/products/{id} → تعديل منتج
/vendor/orders → طلبات منتجاتي
/vendor/payouts → مستحقاتي المالية

---

/admin/dashboard → إحصائيات عامة
/admin/vendors → كل الـ Vendors
/admin/vendors/{id} → الموافقة/الرفض
/admin/products → كل المنتجات
/admin/orders → كل الطلبات
/admin/categories → إدارة الكاتيجوري
/admin/users → إدارة اليوزرز
/admin/payouts → إدارة المدفوعات

---

مش بيعمل Register جديد ❌

الصح:

1. يعمل Register عادي كـ Customer ✅
2. يدخل على /become-vendor ويملا بيانات المتجر ✅
3. Admin يوافق → IsApproved = true ✅
4. بعدها يقدر يدخل /vendor/dashboard ✅

---

-- 3 Roles بس
Customer → يشتري
Vendor → يبيع + يشتري
Admin → يدير كل حاجة

---
