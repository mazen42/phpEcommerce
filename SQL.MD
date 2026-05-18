CREATE TABLE Vendors (
Id INT PRIMARY KEY IDENTITY,

    -- بيانات المتجر
    StoreName      NVARCHAR(200) NOT NULL,
    StoreSlug      NVARCHAR(200) UNIQUE,  -- للـ URL
    Description    NVARCHAR(1000),
    LogoUrl        NVARCHAR(500),

    -- بيانات التواصل
    PhoneNumber    NVARCHAR(20),
    Email          NVARCHAR(256),
    Address        NVARCHAR(500),

    -- ربط بالـ User
    ApplicationUserId NVARCHAR(450) NOT NULL,
    FOREIGN KEY (ApplicationUserId)
        REFERENCES AspNetUsers(Id),

    -- الحالة
    IsApproved     BIT DEFAULT 0,  -- Admin يوافق عليه
    IsActive       BIT DEFAULT 1,
    CreatedAt      DATETIME DEFAULT GETDATE()

## )

ALTER TABLE Products
ADD VendorId INT NOT NULL,
ADD FOREIGN KEY (VendorId) REFERENCES Vendors(Id);

---

-- عشان كل أوردر ممكن يكون فيه منتجات من vendors مختلفين
ALTER TABLE orderDetails
ADD VendorId INT,
ADD VendorPayout DECIMAL(18,2), -- نصيب الـ vendor
ADD FOREIGN KEY (VendorId) REFERENCES Vendors(Id);

---

CREATE TABLE VendorPayouts (
Id INT PRIMARY KEY IDENTITY,
VendorId INT NOT NULL,
OrderDetailId INT NOT NULL,
Amount DECIMAL(18,2),
CommissionRate DECIMAL(5,2), -- نسبة العمولة %
Status NVARCHAR(50), -- Pending/Paid
PaidAt DATETIME,
FOREIGN KEY (VendorId) REFERENCES Vendors(Id),
FOREIGN KEY (OrderDetailId) REFERENCES orderDetails(Id)
)

---

AspNetUsers
│
├──── Vendors (one user = one vendor)
│ │
│ └──── Products ──── Categories
│ │
└──── orderHeaders │
│ │
└──── orderDetails ──── VendorPayouts

---

## Multi-Vendor للـ Schema الثاني 🏪

### أول حاجة — لاحظت إيه؟ 👀

في جدول **Products** فيه حقل **`Author`** — ده معناه إن الـ Schema ده أصلاً لـ **متجر كتب (Bookstore)**!

---

### إذاً مش هتعمل "Author Table" — هتعمل **"Vendor Table"** 🏬

```sql
CREATE TABLE Vendors (
    Id          INT PRIMARY KEY IDENTITY,

    -- بيانات المتجر
    StoreName      NVARCHAR(200) NOT NULL,
    StoreSlug      NVARCHAR(200) UNIQUE,  -- للـ URL
    Description    NVARCHAR(1000),
    LogoUrl        NVARCHAR(500),

    -- بيانات التواصل
    PhoneNumber    NVARCHAR(20),
    Email          NVARCHAR(256),
    Address        NVARCHAR(500),

    -- ربط بالـ User
    ApplicationUserId NVARCHAR(450) NOT NULL,
    FOREIGN KEY (ApplicationUserId)
        REFERENCES AspNetUsers(Id),

    -- الحالة
    IsApproved     BIT DEFAULT 0,  -- Admin يوافق عليه
    IsActive       BIT DEFAULT 1,
    CreatedAt      DATETIME DEFAULT GETDATE()
)
```

---

### التعديلات على الجداول الموجودة 🔧

**1 — Products يضاف عليه VendorId:**

```sql
ALTER TABLE Products
ADD VendorId INT NOT NULL,
ADD FOREIGN KEY (VendorId) REFERENCES Vendors(Id);
```

**2 — orderDetails يضاف عليه VendorId:**

```sql
-- عشان كل أوردر ممكن يكون فيه منتجات من vendors مختلفين
ALTER TABLE orderDetails
ADD VendorId INT,
ADD VendorPayout DECIMAL(18,2),  -- نصيب الـ vendor
ADD FOREIGN KEY (VendorId) REFERENCES Vendors(Id);
```

**3 — جدول جديد للعمولة:**

```sql
CREATE TABLE VendorPayouts (
    Id              INT PRIMARY KEY IDENTITY,
    VendorId        INT NOT NULL,
    OrderDetailId   INT NOT NULL,
    Amount          DECIMAL(18,2),
    CommissionRate  DECIMAL(5,2),  -- نسبة العمولة %
    Status          NVARCHAR(50),  -- Pending/Paid
    PaidAt          DATETIME,
    FOREIGN KEY (VendorId) REFERENCES Vendors(Id),
    FOREIGN KEY (OrderDetailId) REFERENCES orderDetails(Id)
)
```

---

### الصورة الكاملة للـ Schema الجديد 📊

```
AspNetUsers
    │
    ├──── Vendors (one user = one vendor)
    │         │
    │         └──── Products ──── Categories
    │                   │
    └──── orderHeaders  │
              │         │
              └──── orderDetails ──── VendorPayouts
```

---

### ⚠️ نقاط مهمة للـ Multi-Vendor:

| النقطة                 | التفاصيل                          |
| ---------------------- | --------------------------------- |
| **Approval System**    | الـ Admin يوافق على كل Vendor     |
| **Commission**         | تحدد نسبة عمولة لكل Vendor        |
| **Products ownership** | كل Product مرتبط بـ Vendor معين   |
| **Split Orders**       | أوردر واحد ممكن يتقسم على vendors |
| **Payout**             | نظام صرف مستحقات الـ Vendors      |

> **خلاصة:** مش محتاج Author Table — محتاج **Vendor Table** وتعدل على Products و orderDetails وتضيف VendorPayouts 🎯
