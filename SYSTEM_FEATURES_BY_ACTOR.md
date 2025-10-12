# 📋 HỆ THỐNG QUẢN LÝ SINH VIÊN (S-MIS)

## Chức năng chi tiết theo từng Actor

**Dựa trên:** Database ERD + Phân tích yêu cầu thực tế  
**Cập nhật:** October 11, 2025

---

## 🎯 TỔNG QUAN HỆ THỐNG

### **Mục tiêu:**

Xây dựng hệ thống quản lý thông tin sinh viên toàn diện, hỗ trợ:

-   Quản lý người dùng, sinh viên, giảng viên
-   Quản lý điểm, lịch học, lịch thi, điểm danh
-   Đăng ký học phần
-   Quản lý học phí
-   Báo cáo thống kê
-   AI Chatbot hỗ trợ

### **Công nghệ:**

-   Backend: Laravel 11.x
-   Frontend: Blade Templates + Bootstrap 5
-   Database: MySQL
-   AI: OpenAI GPT

### **Cấu trúc Database:**

-   **Tài khoản & Phân quyền:** users, vai_tro (6 vai trò), quyen (30 quyền), vai_tro_quyen, tai_khoan_vai_tro
-   **Nhân sự:** admin, dao_tao, giang_vien, sinh_vien
-   **Học vụ:** khoa, nganh, chuyen_nganh, mon_hoc, lop_hoc_phan, chuong_trinh_khung
-   **Lịch & Điểm:** lich_hoc, lich_thi, diem_danh, dang_ky_mon_hoc, nhap_diem, bang_diem
-   **Tài chính:** hoc_phi
-   **AI & Thông báo:** ai_chatbot_knowledge_base, ai_chatbot_log, thong_bao

---

# 👑 1. ADMIN – Quản trị hệ thống

## **Vai trò:**

Quản trị viên hệ thống, quản lý toàn bộ người dùng và hệ thống (Toàn quyền)

## **Quyền hạn:** 30/30 quyền (100%)

---

### **1.1. QUẢN LÝ TÀI KHOẢN**

_Bảng: `users`, `tai_khoan_vai_tro`_

| STT | Chức năng      | Mô tả chi tiết                          | Database | Priority | Status     |
| --- | -------------- | --------------------------------------- | -------- | -------- | ---------- |
| 1   | Xem tài khoản  | Danh sách tất cả users trong hệ thống   | users    | High     | ✅ Done    |
| 2   | Tạo tài khoản  | Tạo account mới (email, password, name) | users    | High     | ✅ Done    |
| 3   | Sửa tài khoản  | Cập nhật thông tin user, đổi password   | users    | High     | ✅ Done    |
| 4   | Xóa tài khoản  | Xóa user (soft delete)                  | users    | Medium   | ✅ Done    |
| 5   | Reset mật khẩu | Reset password cho user                 | users    | Medium   | 🔄 Planned |

---

### **1.2. GÁN VAI TRÒ**

_Bảng: `vai_tro`, `tai_khoan_vai_tro`_

| STT | Chức năng                 | Mô tả chi tiết                                 | Database          | Priority | Status  |
| --- | ------------------------- | ---------------------------------------------- | ----------------- | -------- | ------- |
| 6   | Gán vai trò cho tài khoản | Gán vai trò: sinh viên, giảng viên, đào tạo... | tai_khoan_vai_tro | High     | ✅ Done |
| 7   | Xem vai trò của user      | Hiển thị vai trò hiện tại                      | tai_khoan_vai_tro | High     | ✅ Done |
| 8   | Đổi vai trò               | Thay đổi vai trò của user                      | tai_khoan_vai_tro | High     | ✅ Done |

---

### **1.3. QUẢN LÝ VAI TRÒ**

_Bảng: `vai_tro`_

| STT | Chức năng       | Mô tả chi tiết               | Database | Priority | Status     |
| --- | --------------- | ---------------------------- | -------- | -------- | ---------- |
| 9   | Xem vai trò     | Danh sách 7 vai trò hệ thống | vai_tro  | Medium   | 🔄 Planned |
| 10  | Tạo vai trò mới | Thêm vai trò mới (nếu cần)   | vai_tro  | Low      | 🔄 Planned |
| 11  | Sửa vai trò     | Đổi tên vai trò              | vai_tro  | Low      | 🔄 Planned |
| 12  | Xóa vai trò     | Xóa vai trò (nếu không dùng) | vai_tro  | Low      | 🔄 Planned |

---

### **1.4. QUẢN LÝ QUYỀN**

_Bảng: `quyen`, `vai_tro_quyen`_

| STT | Chức năng             | Mô tả chi tiết                    | Database      | Priority | Status     |
| --- | --------------------- | --------------------------------- | ------------- | -------- | ---------- |
| 13  | Xem quyền             | Danh sách 30 quyền                | quyen         | Medium   | 🔄 Planned |
| 14  | Tạo quyền             | Thêm quyền mới (xem, sửa, xóa...) | quyen         | Low      | 🔄 Planned |
| 15  | Sửa quyền             | Cập nhật mô tả quyền              | quyen         | Low      | 🔄 Planned |
| 16  | Xóa quyền             | Xóa quyền                         | quyen         | Low      | 🔄 Planned |
| 17  | Gán quyền cho vai trò | Mapping quyền vào vai trò         | vai_tro_quyen | High     | ✅ Done    |

---

### **1.5. QUẢN LÝ DANH MỤC**

_Bảng: `khoa`, `nganh`, `chuyen_nganh`, `dm_trinh_do`, `trang_thai_hoc_tap`_

| STT | Chức năng                  | Mô tả chi tiết                              | Database           | Priority | Status     |
| --- | -------------------------- | ------------------------------------------- | ------------------ | -------- | ---------- |
| 18  | Quản lý Khoa               | CRUD khoa (Công nghệ thông tin, Kinh tế...) | khoa               | High     | 🔄 Planned |
| 19  | Quản lý Ngành              | CRUD ngành (Lập trình, Kế toán...)          | nganh              | High     | 🔄 Planned |
| 20  | Quản lý Chuyên ngành       | CRUD chuyên ngành                           | chuyen_nganh       | High     | 🔄 Planned |
| 21  | Quản lý Trình độ           | CRUD trình độ GV (Thạc sĩ, Tiến sĩ...)      | dm_trinh_do        | Medium   | 🔄 Planned |
| 22  | Quản lý Trạng thái học tập | CRUD trạng thái (Đang học, Bảo lưu...)      | trang_thai_hoc_tap | Medium   | 🔄 Planned |

---

### **1.6. QUẢN LÝ THỜI GIAN**

_Bảng: `khoa_hoc`, `hoc_ky`_

| STT | Chức năng                     | Mô tả chi tiết                   | Database | Priority | Status     |
| --- | ----------------------------- | -------------------------------- | -------- | -------- | ---------- |
| 23  | Quản lý Khóa học              | CRUD khóa học (K16, K17, K18...) | khoa_hoc | High     | 🔄 Planned |
| 24  | Quản lý Học kỳ                | CRUD học kỳ (HK1 2024-2025...)   | hoc_ky   | High     | 🔄 Planned |
| 25  | Cài đặt ngày bắt đầu/kết thúc | Set thời gian học kỳ             | hoc_ky   | High     | 🔄 Planned |

---

### **1.7. QUẢN LÝ PHÒNG HỌC**

_Bảng: `phong_hoc`_

| STT | Chức năng     | Mô tả chi tiết                             | Database  | Priority | Status     |
| --- | ------------- | ------------------------------------------ | --------- | -------- | ---------- |
| 26  | Xem phòng học | Danh sách phòng học                        | phong_hoc | High     | 🔄 Planned |
| 27  | Thêm phòng    | Tạo phòng mới (mã phòng, sức chứa, vị trí) | phong_hoc | High     | 🔄 Planned |
| 28  | Sửa phòng     | Cập nhật thông tin phòng                   | phong_hoc | Medium   | 🔄 Planned |
| 29  | Xóa phòng     | Xóa phòng không dùng                       | phong_hoc | Low      | 🔄 Planned |

---

### **1.8. QUẢN LÝ NHẬT KÝ HỆ THỐNG**

_Tracking hoạt động người dùng_

| STT | Chức năng         | Mô tả chi tiết            | Database     | Priority | Status     |
| --- | ----------------- | ------------------------- | ------------ | -------- | ---------- |
| 30  | Xem log đăng nhập | Xem ai đăng nhập, khi nào | Laravel logs | High     | 🔄 Planned |
| 31  | Xem log thao tác  | Xem ai làm gì (nếu cần)   | Laravel logs | Medium   | 🔄 Planned |
| 32  | Export logs       | Xuất log ra file          | Laravel logs | Low      | 🔄 Planned |

---

### **✅ BỔ SUNG:**

**Admin có thêm quyền:**
| STT | Chức năng | Mô tả chi tiết | Database | Priority | Status |
|-----|-----------|----------------|----------|----------|--------|
| 33 | Cài đặt hệ thống | Cấu hình SMTP, Logo, API Key, Backup... | Laravel config | High | 🔄 Planned |

---

# 🏢 2. ĐÀO TẠO – Quản lý học vụ

## **Vai trò:**

Phòng Đào tạo, quản lý toàn bộ quy trình đào tạo

## **Quyền hạn:** 19/30 quyền (63%)

---

### **2.1. QUẢN LÝ SINH VIÊN**

_Bảng: `sinh_vien`_

| STT | Chức năng          | Mô tả chi tiết                               | Database  | Priority | Status     |
| --- | ------------------ | -------------------------------------------- | --------- | -------- | ---------- |
| 1   | Xem sinh viên      | Danh sách SV, lọc theo khoa/ngành/trạng thái | sinh_vien | High     | ✅ Done    |
| 2   | Tạo sinh viên      | Tạo hồ sơ SV mới (mã SV, họ tên, email...)   | sinh_vien | High     | ✅ Done    |
| 3   | Sửa sinh viên      | Cập nhật thông tin SV, gán ngành, trạng thái | sinh_vien | High     | ✅ Done    |
| 4   | Xóa sinh viên      | Xóa hồ sơ SV                                 | sinh_vien | Low      | ✅ Done    |
| 5   | Import SV từ Excel | Import hàng loạt                             | sinh_vien | High     | 🔄 Planned |
| 6   | Export SV ra Excel | Xuất danh sách                               | sinh_vien | Medium   | 🔄 Planned |

---

### **2.2. QUẢN LÝ GIẢNG VIÊN**

_Bảng: `giang_vien`_

| STT | Chức năng      | Mô tả chi tiết                            | Database   | Priority | Status  |
| --- | -------------- | ----------------------------------------- | ---------- | -------- | ------- |
| 7   | Xem giảng viên | Danh sách GV, lọc theo khoa, trình độ     | giang_vien | High     | ✅ Done |
| 8   | Tạo giảng viên | Tạo hồ sơ GV (mã GV, họ tên, khoa...)     | giang_vien | High     | ✅ Done |
| 9   | Sửa giảng viên | Cập nhật thông tin GV, gán khoa, trình độ | giang_vien | High     | ✅ Done |
| 10  | Xóa giảng viên | Xóa hồ sơ GV                              | giang_vien | Low      | ✅ Done |

---

### **2.3. QUẢN LÝ MÔN HỌC**

_Bảng: `mon_hoc`, `mon_hoc_tien_quyet`_

| STT | Chức năng      | Mô tả chi tiết                            | Database           | Priority | Status     |
| --- | -------------- | ----------------------------------------- | ------------------ | -------- | ---------- |
| 11  | Xem môn học    | Danh sách môn học                         | mon_hoc            | High     | 🔄 Planned |
| 12  | Tạo môn học    | Thêm môn mới (mã môn, tên, số tín chỉ...) | mon_hoc            | High     | 🔄 Planned |
| 13  | Sửa môn học    | Cập nhật thông tin, chỉnh sửa thông tin   | mon_hoc            | Medium   | 🔄 Planned |
| 14  | Xóa môn học    | Xóa môn không dùng                        | mon_hoc            | Low      | 🔄 Planned |
| 15  | Gán tiên quyết | Gán môn tiên quyết cho môn học            | mon_hoc_tien_quyet | High     | 🔄 Planned |

---

### **2.4. QUẢN LÝ CHƯƠNG TRÌNH KHUNG**

_Bảng: `chuong_trinh_khung`_

| STT | Chức năng                 | Mô tả chi tiết                       | Database           | Priority | Status     |
| --- | ------------------------- | ------------------------------------ | ------------------ | -------- | ---------- |
| 16  | Xem chương trình khung    | Xem thứ tự môn học theo chuyên ngành | chuong_trinh_khung | High     | 🔄 Planned |
| 17  | Gán môn vào chương trình  | Gán môn vào chuyên ngành theo học kỳ | chuong_trinh_khung | High     | 🔄 Planned |
| 18  | Sửa thứ tự môn            | Đổi học kỳ gợi ý của môn             | chuong_trinh_khung | Medium   | 🔄 Planned |
| 19  | Xóa môn khỏi chương trình | Xóa môn không còn dạy                | chuong_trinh_khung | Low      | 🔄 Planned |

---

### **2.5. QUẢN LÝ LỚP HỌC PHẦN**

_Bảng: `lop_hoc_phan`, `lop_hoc_phan_giang_vien`_

| STT | Chức năng        | Mô tả chi tiết                              | Database                | Priority | Status     |
| --- | ---------------- | ------------------------------------------- | ----------------------- | -------- | ---------- |
| 20  | Xem lớp học phần | Danh sách lớp HP theo học kỳ                | lop_hoc_phan            | High     | 🔄 Planned |
| 21  | Tạo lớp HP       | Tạo lớp mới (mã lớp, môn, học kỳ, sức chứa) | lop_hoc_phan            | High     | 🔄 Planned |
| 22  | Sửa lớp HP       | Cập nhật thông tin, cấu hình đầu điểm       | lop_hoc_phan            | Medium   | 🔄 Planned |
| 23  | Xóa lớp HP       | Xóa lớp chưa có SV                          | lop_hoc_phan            | Low      | 🔄 Planned |
| 24  | Gán giảng viên   | Phân công GV dạy lớp                        | lop_hoc_phan_giang_vien | High     | 🔄 Planned |

---

### **2.6. QUẢN LÝ LỊCH HỌC**

_Bảng: `lich_hoc`_

| STT | Chức năng    | Mô tả chi tiết                                       | Database | Priority | Status     |
| --- | ------------ | ---------------------------------------------------- | -------- | -------- | ---------- |
| 25  | Xem lịch học | Xem thời khóa biểu theo tuần/tháng                   | lich_hoc | High     | 🔄 Planned |
| 26  | Tạo lịch học | Tạo lịch cho lớp HP, phân phòng, kiểm tra trùng lịch | lich_hoc | High     | 🔄 Planned |
| 27  | Sửa lịch học | Đổi giờ, đổi phòng                                   | lich_hoc | Medium   | 🔄 Planned |
| 28  | Xóa lịch học | Hủy buổi học                                         | lich_hoc | Low      | 🔄 Planned |

---

### **2.7. QUẢN LÝ LỊCH THI**

_Bảng: `lich_thi`_

| STT | Chức năng    | Mô tả chi tiết                              | Database | Priority | Status     |
| --- | ------------ | ------------------------------------------- | -------- | -------- | ---------- |
| 29  | Xem lịch thi | Xem lịch thi các lớp HP                     | lich_thi | High     | 🔄 Planned |
| 30  | Tạo lịch thi | Tạo lịch thi, upload đề thi, phân phòng thi | lich_thi | High     | 🔄 Planned |
| 31  | Sửa lịch thi | Đổi ngày thi, đổi phòng                     | lich_thi | Medium   | 🔄 Planned |
| 32  | Xóa lịch thi | Hủy lịch thi                                | lich_thi | Low      | 🔄 Planned |

---

### **2.8. QUẢN LÝ HỌC PHÍ**

_Bảng: `hoc_phi`_

| STT | Chức năng       | Mô tả chi tiết                                           | Database | Priority | Status     |
| --- | --------------- | -------------------------------------------------------- | -------- | -------- | ---------- |
| 33  | Xem học phí     | Xem học phí theo kỳ, theo SV                             | hoc_phi  | High     | 🔄 Planned |
| 34  | Gán học phí     | Gán học phí cho SV theo kỳ, cập nhật trạng thái nộp tiền | hoc_phi  | High     | 🔄 Planned |
| 35  | Báo cáo học phí | Thống kê thu học phí                                     | hoc_phi  | High     | 🔄 Planned |

---

### **2.9. QUẢN LÝ ĐIỂM**

_Bảng: `dang_ky_mon_hoc`, `nhap_diem`, `bang_diem`_

| STT | Chức năng            | Mô tả chi tiết                               | Database        | Priority | Status     |
| --- | -------------------- | -------------------------------------------- | --------------- | -------- | ---------- |
| 36  | Xem điểm             | Xem điểm SV, điểm trung bình học kỳ/tích lũy | bang_diem       | High     | 🔄 Planned |
| 37  | Tính điểm trung bình | Tính toán điểm TB học kỳ, tích lũy           | bang_diem       | High     | 🔄 Planned |
| 38  | Xét qua môn          | Xét qua môn, tính tích lũy                   | dang_ky_mon_hoc | High     | 🔄 Planned |

---

### **2.10. QUẢN LÝ ĐIỂM DANH**

_Bảng: `diem_danh`_

| STT | Chức năng                | Mô tả chi tiết                 | Database  | Priority | Status     |
| --- | ------------------------ | ------------------------------ | --------- | -------- | ---------- |
| 39  | Xem thống kê điểm danh   | Xem thống kê theo lớp, theo SV | diem_danh | High     | 🔄 Planned |
| 40  | Xem sinh viên vắng nhiều | Cảnh báo SV vắng quá 20%       | diem_danh | High     | 🔄 Planned |

---

### **2.11. QUẢN LÝ CHATBOT AI**

_Bảng: `ai_chatbot_knowledge_base`, `ai_chatbot_log`_

| STT | Chức năng          | Mô tả chi tiết                 | Database                  | Priority | Status     |
| --- | ------------------ | ------------------------------ | ------------------------- | -------- | ---------- |
| 41  | Xem knowledge base | Xem câu hỏi/trả lời mẫu        | ai_chatbot_knowledge_base | Medium   | 🔄 Planned |
| 42  | Thêm/Sửa knowledge | Cập nhật kiến thức cho chatbot | ai_chatbot_knowledge_base | Medium   | 🔄 Planned |
| 43  | Xem log hội thoại  | Xem lịch sử chat của SV        | ai_chatbot_log            | Medium   | 🔄 Planned |

---

# 👨‍🏫 3. GIẢNG VIÊN – Người dạy

## **Vai trò:**

Giảng viên giảng dạy, chấm điểm, điểm danh

## **Quyền hạn:** 5/30 quyền (17%)

---

### **3.1. XEM THÔNG TIN CÁ NHÂN**

_Bảng: `giang_vien`, `users`_

| STT | Chức năng             | Mô tả chi tiết                               | Database   | Priority | Status  |
| --- | --------------------- | -------------------------------------------- | ---------- | -------- | ------- |
| 1   | Xem hồ sơ GV          | Xem thông tin cá nhân (trình độ, chuyên môn) | giang_vien | High     | ✅ Done |
| 2   | Cập nhật ảnh đại diện | Upload ảnh đại diện                          | giang_vien | Medium   | ✅ Done |
| 3   | Đổi mật khẩu          | Thay đổi password                            | users      | High     | ✅ Done |

---

### **3.2. XEM LỚP HỌC PHẦN PHỤ TRÁCH**

_Bảng: `lop_hoc_phan`, `lop_hoc_phan_giang_vien`, `dang_ky_mon_hoc`_

| STT | Chức năng        | Mô tả chi tiết                          | Database                | Priority | Status     |
| --- | ---------------- | --------------------------------------- | ----------------------- | -------- | ---------- |
| 4   | Xem lớp dạy      | Danh sách lớp HP mình phụ trách         | lop_hoc_phan_giang_vien | High     | 🔄 Planned |
| 5   | Xem danh sách SV | Xem sinh viên trong lớp, trạng thái lớp | dang_ky_mon_hoc         | High     | 🔄 Planned |

---

### **3.3. XEM LỊCH GIẢNG DẠY**

_Bảng: `lich_hoc`_

| STT | Chức năng    | Mô tả chi tiết                                   | Database | Priority | Status     |
| --- | ------------ | ------------------------------------------------ | -------- | -------- | ---------- |
| 6   | Xem lịch học | Lịch học theo tuần/tháng, phòng học, link online | lich_hoc | High     | 🔄 Planned |
| 7   | Export lịch  | Xuất lịch ra PDF/Excel                           | lich_hoc | Medium   | 🔄 Planned |

---

### **3.4. ĐIỂM DANH SINH VIÊN**

_Bảng: `diem_danh`_

| STT | Chức năng         | Mô tả chi tiết                                           | Database  | Priority | Status     |
| --- | ----------------- | -------------------------------------------------------- | --------- | -------- | ---------- |
| 8   | Điểm danh         | Đánh dấu có mặt/vắng/đi trễ/nghỉ phép theo từng buổi học | diem_danh | High     | 🔄 Planned |
| 9   | Xem thống kê vắng | Xem SV vắng bao nhiêu buổi                               | diem_danh | High     | 🔄 Planned |
| 10  | Sửa điểm danh     | Chỉnh sửa trạng thái điểm danh (trong buổi học)          | diem_danh | Medium   | 🔄 Planned |

---

### **3.5. NHẬP ĐIỂM**

_Bảng: `nhap_diem`, `cau_hinh_dau_diem`, `dang_ky_mon_hoc`_

| STT | Chức năng         | Mô tả chi tiết                                        | Database          | Priority | Status     |
| --- | ----------------- | ----------------------------------------------------- | ----------------- | -------- | ---------- |
| 11  | Xem cấu hình điểm | Xem đầu điểm: chuyên cần, giữa kỳ, cuối kỳ...         | cau_hinh_dau_diem | High     | 🔄 Planned |
| 12  | Nhập điểm         | Nhập điểm theo từng đầu điểm (chuyên cần, giữa kỳ...) | nhap_diem         | High     | 🔄 Planned |
| 13  | Xem điểm đã nhập  | Xem lại điểm của lớp                                  | nhap_diem         | High     | 🔄 Planned |
| 14  | Export bảng điểm  | Xuất điểm ra Excel                                    | dang_ky_mon_hoc   | Medium   | 🔄 Planned |

**Lưu ý:** GV không được SỬA điểm sau khi nhập (chỉ Đào tạo mới sửa được)

---

### **3.6. XEM DANH SÁCH SINH VIÊN**

_Bảng: `sinh_vien`, `dang_ky_mon_hoc`_

| STT | Chức năng        | Mô tả chi tiết                          | Database        | Priority | Status     |
| --- | ---------------- | --------------------------------------- | --------------- | -------- | ---------- |
| 15  | Xem SV trong lớp | Tra cứu sinh viên trong lớp HP mình dạy | dang_ky_mon_hoc | High     | 🔄 Planned |
| 16  | Xem thông tin SV | Xem thông tin cá nhân SV (chỉ đọc)      | sinh_vien       | Medium   | 🔄 Planned |

---

### **3.7. XEM LỊCH THI**

_Bảng: `lich_thi`_

| STT | Chức năng    | Mô tả chi tiết                      | Database | Priority | Status     |
| --- | ------------ | ----------------------------------- | -------- | -------- | ---------- |
| 17  | Xem lịch thi | Xem lịch thi của lớp mình phụ trách | lich_thi | High     | 🔄 Planned |

---

### **3.8. CHATBOT AI**

_Bảng: `ai_chatbot_log`_

| STT | Chức năng   | Mô tả chi tiết                                         | Database       | Priority | Status     |
| --- | ----------- | ------------------------------------------------------ | -------------- | -------- | ---------- |
| 18  | Chat với AI | Hỏi đáp về quy trình nhập điểm, lịch thi, lớp học phần | ai_chatbot_log | Medium   | 🔄 Planned |

---

# 🎓 4. SINH VIÊN – Người học

## **Vai trò:**

Sinh viên tra cứu thông tin cá nhân, đăng ký môn học

## **Quyền hạn:** 2/30 quyền (7%)

---

### **4.1. XEM THÔNG TIN CÁ NHÂN**

_Bảng: `sinh_vien`, `users`_

| STT | Chức năng    | Mô tả chi tiết                                    | Database  | Priority | Status  |
| --- | ------------ | ------------------------------------------------- | --------- | -------- | ------- |
| 1   | Xem hồ sơ SV | Hồ sơ sinh viên, trạng thái học tập, ảnh đại diện | sinh_vien | High     | ✅ Done |
| 2   | Cập nhật ảnh | Upload ảnh đại diện                               | sinh_vien | Medium   | ✅ Done |
| 3   | Đổi mật khẩu | Thay đổi password                                 | users     | High     | ✅ Done |

---

### **4.2. ĐĂNG KÝ MÔN HỌC**

_Bảng: `dang_ky_mon_hoc`, `lop_hoc_phan`, `chuong_trinh_khung`, `mon_hoc_tien_quyet`_

| STT | Chức năng               | Mô tả chi tiết                                       | Database              | Priority | Status     |
| --- | ----------------------- | ---------------------------------------------------- | --------------------- | -------- | ---------- |
| 4   | Xem môn mở ĐKHP         | Xem lớp học phần mở đăng ký (trạng thái: mo_dang_ky) | lop_hoc_phan          | High     | 🔄 Planned |
| 5   | Đăng ký môn             | Chọn lớp HP, kiểm tra trùng lịch                     | dang_ky_mon_hoc       | High     | 🔄 Planned |
| 6   | Kiểm tra môn tiên quyết | Validate đã học môn tiên quyết chưa                  | mon_hoc_tien_quyet    | High     | 🔄 Planned |
| 7   | Kiểm tra điều kiện      | Check SV đã đóng học phí, còn slot trong lớp         | lop_hoc_phan, hoc_phi | High     | 🔄 Planned |
| 8   | Hủy đăng ký             | Hủy trong thời gian cho phép                         | dang_ky_mon_hoc       | Medium   | 🔄 Planned |

---

### **4.3. TRA CỨU LỊCH HỌC**

_Bảng: `lich_hoc`, `dang_ky_mon_hoc`_

| STT | Chức năng     | Mô tả chi tiết                     | Database | Priority | Status     |
| --- | ------------- | ---------------------------------- | -------- | -------- | ---------- |
| 9   | Xem lịch học  | Xem thời khóa biểu theo tuần/tháng | lich_hoc | High     | 🔄 Planned |
| 10  | Xem phòng học | Phòng học, link online (nếu có)    | lich_hoc | High     | 🔄 Planned |
| 11  | Export lịch   | Xuất lịch ra PDF/Excel             | lich_hoc | Medium   | 🔄 Planned |

---

### **4.4. TRA CỨU LỊCH THI**

_Bảng: `lich_thi`_

| STT | Chức năng       | Mô tả chi tiết                           | Database | Priority | Status     |
| --- | --------------- | ---------------------------------------- | -------- | -------- | ---------- |
| 12  | Xem lịch thi    | Xem lịch thi, phòng thi, link thi online | lich_thi | High     | 🔄 Planned |
| 13  | Download đề thi | Download file PDF đề thi (nếu có)        | lich_thi | Medium   | 🔄 Planned |

---

### **4.5. TRA CỨU ĐIỂM**

_Bảng: `dang_ky_mon_hoc`, `bang_diem`, `nhap_diem`_

| STT | Chức năng         | Mô tả chi tiết                                      | Database        | Priority | Status     |
| --- | ----------------- | --------------------------------------------------- | --------------- | -------- | ---------- |
| 14  | Xem điểm từng môn | Xem điểm từng môn, điểm trung bình học kỳ, tích lũy | dang_ky_mon_hoc | High     | 🔄 Planned |
| 15  | Xem điểm chi tiết | Xem điểm chuyên cần, giữa kỳ, cuối kỳ...            | nhap_diem       | High     | 🔄 Planned |
| 16  | Xem điểm tích lũy | Xem GPA học kỳ, GPA tích lũy                        | bang_diem       | High     | 🔄 Planned |
| 17  | Xem xếp loại      | Xuất sắc/Giỏi/Khá/Trung bình/Yếu                    | bang_diem       | Medium   | 🔄 Planned |

---

### **4.6. TRA CỨU HỌC PHÍ**

_Bảng: `hoc_phi`_

| STT | Chức năng        | Mô tả chi tiết                               | Database | Priority | Status     |
| --- | ---------------- | -------------------------------------------- | -------- | -------- | ---------- |
| 18  | Xem học phí      | Xem số tiền cần đóng, trạng thái đã nộp/chưa | hoc_phi  | High     | 🔄 Planned |
| 19  | Xem lịch sử đóng | Xem lịch sử đóng học phí từng kỳ             | hoc_phi  | Medium   | 🔄 Planned |

---

### **4.7. XEM ĐIỂM DANH**

_Bảng: `diem_danh`_

| STT | Chức năng           | Mô tả chi tiết                                  | Database  | Priority | Status     |
| --- | ------------------- | ----------------------------------------------- | --------- | -------- | ---------- |
| 20  | Xem điểm danh       | Xem số buổi có mặt/vắng/đi trễ... theo từng môn | diem_danh | High     | 🔄 Planned |
| 21  | Cảnh báo vắng nhiều | Thông báo khi vắng > 20%                        | diem_danh | High     | 🔄 Planned |

---

### **4.8. CHATBOT AI**

_Bảng: `ai_chatbot_log`_

| STT | Chức năng   | Mô tả chi tiết                                    | Database       | Priority | Status     |
| --- | ----------- | ------------------------------------------------- | -------------- | -------- | ---------- |
| 22  | Chat với AI | Hỏi đáp về học phí, môn học, chương trình đào tạo | ai_chatbot_log | High     | 🔄 Planned |

---

# 📊 TIẾN ĐỘ TỔNG QUAN

## **✅ Đã hoàn thành (Phase 1):**

-   ✅ Hệ thống đăng nhập/đăng xuất
-   ✅ Phân quyền đầy đủ (7 vai trò, 30 quyền)
-   ✅ Quản lý người dùng (CRUD)
-   ✅ Quản lý sinh viên (CRUD)
-   ✅ Quản lý giảng viên (CRUD)
-   ✅ Quản lý đào tạo (CRUD)
-   ✅ Hồ sơ cá nhân (View, Update Avatar)
-   ✅ Database ERD hoàn chỉnh (29 bảng)

## **🔄 Đang lên kế hoạch (Phase 2-4):**

-   🔄 Quản lý Danh mục (Khoa, Ngành, Môn học, Phòng học...)
-   🔄 Quản lý Chương trình khung
-   🔄 Quản lý Lớp học phần
-   🔄 Đăng ký học phần
-   🔄 Quản lý Lịch học, Lịch thi
-   🔄 Điểm danh
-   🔄 Nhập điểm, Xem điểm
-   🔄 Quản lý Học phí
-   🔄 AI Chatbot
-   🔄 Báo cáo & Thống kê
-   🔄 Thông báo

---

# 🎯 ROADMAP PHÁT TRIỂN

## **Phase 1: Core System** ✅ (Đã xong)

-   [x] Authentication & Authorization
-   [x] User Management (Admin, Đào tạo, GV, SV)
-   [x] Profile Management
-   [x] Database Design (29 tables)

## **Phase 2: Academic Foundation** (Tiếp theo - Ưu tiên cao)

**Mục tiêu:** Xây dựng nền tảng quản lý học vụ

### **Sprint 1: Danh mục cơ bản** (1-2 tuần)

-   [ ] Quản lý Khoa
-   [ ] Quản lý Ngành, Chuyên ngành
-   [ ] Quản lý Môn học
-   [ ] Quản lý Trình độ GV
-   [ ] Quản lý Trạng thái học tập
-   [ ] Quản lý Khóa học, Học kỳ
-   [ ] Quản lý Phòng học

### **Sprint 2: Chương trình khung** (1 tuần)

-   [ ] CRUD Chương trình khung
-   [ ] Gán môn vào chuyên ngành theo học kỳ
-   [ ] Thiết lập môn tiên quyết
-   [ ] View chương trình khung theo chuyên ngành

### **Sprint 3: Lớp học phần** (2 tuần)

-   [ ] CRUD Lớp học phần
-   [ ] Phân công giảng viên
-   [ ] Cấu hình đầu điểm (chuyên cần, giữa kỳ, cuối kỳ...)
-   [ ] Quản lý trạng thái lớp (mở ĐKHP, đang học, kết thúc)

## **Phase 3: Student Services** (Dịch vụ sinh viên)

**Mục tiêu:** Các tính năng phục vụ sinh viên

### **Sprint 4: Đăng ký học phần** (2 tuần)

-   [ ] View môn mở đăng ký
-   [ ] Đăng ký lớp học phần
-   [ ] Validate trùng lịch
-   [ ] Validate môn tiên quyết
-   [ ] Validate slot còn trống
-   [ ] Hủy đăng ký

### **Sprint 5: Lịch học & Lịch thi** (2 tuần)

-   [ ] Tạo lịch học (Auto check trùng phòng)
-   [ ] Xem lịch học (SV, GV)
-   [ ] Export lịch PDF
-   [ ] Tạo lịch thi
-   [ ] Upload đề thi
-   [ ] Xem/Download lịch thi

### **Sprint 6: Điểm danh** (1 tuần)

-   [ ] GV điểm danh từng buổi
-   [ ] SV xem điểm danh
-   [ ] Thống kê vắng
-   [ ] Cảnh báo vắng > 20%

### **Sprint 7: Quản lý điểm** (2 tuần)

-   [ ] GV nhập điểm theo đầu điểm
-   [ ] Tính điểm tổng kết (hệ 10, hệ 4, chữ)
-   [ ] SV xem điểm
-   [ ] Tính GPA học kỳ/tích lũy
-   [ ] Xét qua môn
-   [ ] Export bảng điểm

### **Sprint 8: Học phí** (1 tuần)

-   [ ] Gán học phí theo học kỳ
-   [ ] SV xem học phí
-   [ ] Cập nhật trạng thái đóng
-   [ ] Báo cáo thu học phí

## **Phase 4: Advanced Features** (Tính năng nâng cao)

**Mục tiêu:** Tối ưu trải nghiệm người dùng

### **Sprint 9: AI Chatbot** (2-3 tuần)

-   [ ] Setup OpenAI API
-   [ ] Tạo knowledge base
-   [ ] Chat interface
-   [ ] Log conversations
-   [ ] Admin quản lý knowledge
-   [ ] Train bot với dữ liệu trường

### **Sprint 10: Thông báo** (1 tuần)

-   [ ] Hệ thống thông báo
-   [ ] Gửi theo đối tượng (SV, GV, all)
-   [ ] Đánh dấu đã đọc
-   [ ] Push notification (optional)

### **Sprint 11: Báo cáo & Thống kê** (2 tuần)

-   [ ] Dashboard tổng quan
-   [ ] Báo cáo sinh viên
-   [ ] Báo cáo điểm
-   [ ] Báo cáo học phí
-   [ ] Báo cáo điểm danh
-   [ ] Export PDF/Excel

### **Sprint 12: Tối ưu & Bảo mật** (1-2 tuần)

-   [ ] Optimization queries
-   [ ] Cache Redis
-   [ ] Security check
-   [ ] Unit testing
-   [ ] API documentation

## **Phase 5: Deployment & Maintenance**

-   [ ] Server setup
-   [ ] CI/CD pipeline
-   [ ] Backup strategy
-   [ ] Monitoring
-   [ ] User training
-   [ ] Documentation

---

# 📈 THỐNG KÊ DỰ ÁN

### **Database:**

-   **29 bảng** đã thiết kế
-   **7 vai trò** phân quyền
-   **30 quyền** chi tiết
-   **4 enum** types

### **Chức năng:**

-   **Admin:** 32 chức năng
-   **Đào tạo:** 43 chức năng
-   **Giảng viên:** 18 chức năng
-   **Sinh viên:** 22 chức năng
-   **Tổng:** ~115 chức năng

### **Timeline dự kiến:**

-   **Phase 1:** ✅ Hoàn thành (2 tuần)
-   **Phase 2:** 🔄 4-5 tuần
-   **Phase 3:** 🔄 8-9 tuần
-   **Phase 4:** 🔄 6-7 tuần
-   **Phase 5:** 🔄 2-3 tuần
-   **TỔNG:** ~22-26 tuần (5-6 tháng)

---

# 📞 PROJECT INFO

**Project:** S-MIS (Student Management Information System)  
**Version:** 1.0.0  
**Tech Stack:** Laravel 11 + MySQL + Bootstrap 5 + OpenAI  
**Database:** 29 tables, 7 roles, 30 permissions  
**Last Updated:** October 11, 2025

---

**© 2025 S-MIS Project. All rights reserved.**
| Chức năng | Mô tả | Priority | Status |
|-----------|-------|----------|--------|
| Xem danh sách | Xem tất cả users (Admin, Đào tạo, GV, SV) | High | ✅ Done |
| Thêm người dùng | Tạo tài khoản mới, gán vai trò | High | ✅ Done |
| Sửa thông tin | Cập nhật thông tin, đổi vai trò | High | ✅ Done |
| Xóa người dùng | Xóa tài khoản (soft delete) | Medium | ✅ Done |
| Phân quyền | Gán vai trò phân quyền (7 vai trò) | High | ✅ Done |
| Reset mật khẩu | Reset password cho user | Medium | 🔄 Planned |

### **B. QUẢN LÝ SINH VIÊN** ✅

| Chức năng      | Mô tả                                  | Priority | Status     |
| -------------- | -------------------------------------- | -------- | ---------- |
| Xem danh sách  | Danh sách SV, lọc theo khoa/ngành/khóa | High     | ✅ Done    |
| Thêm sinh viên | Tạo hồ sơ SV mới                       | High     | ✅ Done    |
| Sửa thông tin  | Cập nhật thông tin cá nhân, học tập    | High     | ✅ Done    |
| Xóa sinh viên  | Xóa hồ sơ (soft delete)                | Low      | ✅ Done    |
| Upload ảnh     | Upload ảnh đại diện cho SV             | Medium   | ✅ Done    |
| Import Excel   | Import hàng loạt từ file Excel         | High     | 🔄 Planned |
| Export Excel   | Xuất danh sách ra Excel                | Medium   | 🔄 Planned |

### **C. QUẢN LÝ GIẢNG VIÊN** ✅

| Chức năng           | Mô tả                        | Priority | Status     |
| ------------------- | ---------------------------- | -------- | ---------- |
| Xem danh sách       | Danh sách GV, lọc theo khoa  | High     | ✅ Done    |
| Thêm giảng viên     | Tạo hồ sơ GV mới             | High     | ✅ Done    |
| Sửa thông tin       | Cập nhật thông tin, trình độ | High     | ✅ Done    |
| Xóa giảng viên      | Xóa hồ sơ GV                 | Low      | ✅ Done    |
| Phân công giảng dạy | Gán GV cho lớp học phần      | High     | 🔄 Planned |

### **D. QUẢN LÝ ĐIỂM** 🔄

| Chức năng      | Mô tả                      | Priority | Status     |
| -------------- | -------------------------- | -------- | ---------- |
| Xem điểm       | Xem điểm tất cả sinh viên  | High     | 🔄 Planned |
| Nhập điểm      | Nhập điểm cho lớp học phần | High     | 🔄 Planned |
| Sửa điểm       | Chỉnh sửa điểm đã nhập     | Medium   | 🔄 Planned |
| Xóa điểm       | Xóa bảng điểm              | Low      | 🔄 Planned |
| Khóa điểm      | Khóa điểm sau khi hoàn tất | Medium   | 🔄 Planned |
| Xuất bảng điểm | Export điểm ra PDF/Excel   | High     | 🔄 Planned |

### **E. QUẢN LÝ LỚP HỌC** 🔄

| Chức năng    | Mô tả                   | Priority | Status     |
| ------------ | ----------------------- | -------- | ---------- |
| Xem lớp học  | Danh sách lớp học phần  | High     | 🔄 Planned |
| Tạo lớp học  | Tạo lớp học phần mới    | High     | 🔄 Planned |
| Sửa lớp học  | Cập nhật thông tin lớp  | Medium   | 🔄 Planned |
| Xóa lớp học  | Xóa lớp học             | Low      | 🔄 Planned |
| Phân công GV | Gán giảng viên cho lớp  | High     | 🔄 Planned |
| Danh sách SV | Xem sinh viên trong lớp | High     | 🔄 Planned |

### **F. QUẢN LÝ LỊCH HỌC** 🔄

| Chức năng        | Mô tả                          | Priority | Status     |
| ---------------- | ------------------------------ | -------- | ---------- |
| Xem lịch học     | Lịch giảng dạy theo tuần/tháng | High     | 🔄 Planned |
| Tạo lịch học     | Tạo lịch học cho lớp           | High     | 🔄 Planned |
| Sửa lịch học     | Đổi giờ, đổi phòng             | Medium   | 🔄 Planned |
| Xóa lịch học     | Hủy buổi học                   | Low      | 🔄 Planned |
| Xếp lịch tự động | AI gợi ý lịch tối ưu           | High     | 🔄 Planned |

### **G. QUẢN LÝ DANH MỤC** 🔄

| Chức năng         | Mô tả            | Priority | Status     |
| ----------------- | ---------------- | -------- | ---------- |
| Quản lý Khoa      | CRUD khoa        | High     | 🔄 Planned |
| Quản lý Ngành     | CRUD ngành       | High     | 🔄 Planned |
| Quản lý Môn học   | CRUD môn học     | High     | 🔄 Planned |
| Quản lý Học kỳ    | CRUD học kỳ      | High     | 🔄 Planned |
| Quản lý Phòng học | CRUD phòng học   | Medium   | 🔄 Planned |
| Quản lý Trình độ  | CRUD trình độ GV | Low      | 🔄 Planned |

### **H. BÁO CÁO & THỐNG KÊ** 🔄

| Chức năng           | Mô tả                       | Priority | Status     |
| ------------------- | --------------------------- | -------- | ---------- |
| Dashboard tổng quan | Biểu đồ thống kê            | High     | 🔄 Planned |
| Báo cáo sinh viên   | Thống kê SV theo khóa/ngành | High     | 🔄 Planned |
| Báo cáo điểm        | Thống kê điểm trung bình    | High     | 🔄 Planned |
| Báo cáo học phí     | Thống kê thu học phí        | Medium   | 🔄 Planned |
| Xuất báo cáo        | Export PDF/Excel            | High     | 🔄 Planned |

### **I. CÀI ĐẶT HỆ THỐNG** 🔐

| Chức năng       | Mô tả              | Priority | Status     |
| --------------- | ------------------ | -------- | ---------- |
| Cấu hình Email  | SMTP settings      | Medium   | 🔄 Planned |
| Cấu hình Logo   | Upload logo trường | Low      | 🔄 Planned |
| Cấu hình AI     | API Key OpenAI     | High     | 🔄 Planned |
| Backup Database | Sao lưu dữ liệu    | High     | 🔄 Planned |
| Xem Logs        | Xem log hệ thống   | Medium   | 🔄 Planned |
| Quản lý Cache   | Clear cache        | Low      | 🔄 Planned |

---

# 👨‍💼 2. ADMIN

## **Vai trò:**

Quản trị viên thường, quản lý hàng ngày

## **Quyền hạn:** 29/30 quyền (97%)

### **Quyền giống Super Admin:**

✅ Tất cả chức năng từ A → H

### **Quyền KHÔNG có:**

❌ **Cài đặt hệ thống** (Mục I)

### **Lý do:**

Bảo vệ cấu hình quan trọng, chỉ Super Admin mới thay đổi được

---

# 📚 3. TRƯỞNG PHÒNG ĐÀO TẠO

## **Vai trò:**

Quản lý công tác đào tạo

## **Quyền hạn:** 19/30 quyền (63%)

### **A. QUẢN LÝ SINH VIÊN** ✅

| Chức năng         | Status |
| ----------------- | ------ |
| ✅ Xem danh sách  | Done   |
| ✅ Thêm sinh viên | Done   |
| ✅ Sửa thông tin  | Done   |
| ✅ Xóa sinh viên  | Done   |

### **B. QUẢN LÝ GIẢNG VIÊN**

| Chức năng        | Status         |
| ---------------- | -------------- |
| ✅ Xem danh sách | Done           |
| ❌ Thêm/Sửa/Xóa  | Không có quyền |

### **C. QUẢN LÝ ĐIỂM** 🔄

| Chức năng    | Status         |
| ------------ | -------------- |
| ✅ Xem điểm  | Planned        |
| ✅ Nhập điểm | Planned        |
| ✅ Sửa điểm  | Planned        |
| ❌ Xóa điểm  | Không có quyền |

### **D. QUẢN LÝ LỚP HỌC** 🔄

| Chức năng      | Status         |
| -------------- | -------------- |
| ✅ Xem lớp học | Planned        |
| ✅ Tạo lớp học | Planned        |
| ✅ Sửa lớp học | Planned        |
| ❌ Xóa lớp học | Không có quyền |

### **E. QUẢN LÝ LỊCH HỌC** 🔄

| Chức năng       | Status         |
| --------------- | -------------- |
| ✅ Xem lịch học | Planned        |
| ✅ Tạo lịch học | Planned        |
| ✅ Sửa lịch học | Planned        |
| ❌ Xóa lịch học | Không có quyền |

### **F. QUẢN LÝ DANH MỤC** 🔄

| Chức năng          | Status  |
| ------------------ | ------- |
| ✅ Quản lý Khoa    | Planned |
| ✅ Quản lý Ngành   | Planned |
| ✅ Quản lý Môn học | Planned |

### **G. BÁO CÁO** 🔄

| Chức năng       | Status  |
| --------------- | ------- |
| ✅ Xem báo cáo  | Planned |
| ✅ Xuất báo cáo | Planned |

---

# 👔 4. NHÂN VIÊN ĐÀO TẠO

## **Vai trò:**

Nhân viên hỗ trợ công tác đào tạo

## **Quyền hạn:** 7/30 quyền (23%)

### **Chức năng chính:**

| Chức năng           | Status  |
| ------------------- | ------- |
| ✅ Xem sinh viên    | Done    |
| ✅ Sửa thông tin SV | Done    |
| ✅ Xem giảng viên   | Done    |
| ✅ Xem điểm         | Planned |
| ✅ Xem lớp học      | Planned |
| ✅ Xem lịch học     | Planned |
| ✅ Xem báo cáo      | Planned |

### **KHÔNG được:**

❌ Thêm/Xóa bất kỳ dữ liệu nào
❌ Nhập/Sửa điểm
❌ Tạo/Sửa lớp học, lịch học

---

# 👨‍🏫 5. GIẢNG VIÊN CHỦ NHIỆM

## **Vai trò:**

Giảng viên + Quản lý lớp chủ nhiệm

## **Quyền hạn:** 9/30 quyền (30%)

### **A. QUẢN LÝ SINH VIÊN (Lớp mình)**

| Chức năng        | Status |
| ---------------- | ------ |
| ✅ Xem danh sách | Done   |
| ✅ Sửa thông tin | Done   |

### **B. QUẢN LÝ ĐIỂM** 🔄

| Chức năng    | Status  |
| ------------ | ------- |
| ✅ Xem điểm  | Planned |
| ✅ Nhập điểm | Planned |
| ✅ Sửa điểm  | Planned |

### **C. QUẢN LÝ LỚP HỌC** 🔄

| Chức năng      | Status  |
| -------------- | ------- |
| ✅ Xem lớp học | Planned |

### **D. QUẢN LÝ LỊCH HỌC** 🔄

| Chức năng        | Status  |
| ---------------- | ------- |
| ✅ Xem lịch học  | Planned |
| ✅ Thêm lịch học | Planned |
| ✅ Sửa lịch học  | Planned |

**Đặc quyền:** Được tạo/sửa lịch học cho lớp mình quản lý

---

# 👨‍🏫 6. GIẢNG VIÊN

## **Vai trò:**

Giảng viên giảng dạy

## **Quyền hạn:** 5/30 quyền (17%)

### **Chức năng:**

| Chức năng                  | Status  |
| -------------------------- | ------- |
| ✅ Xem sinh viên (lớp dạy) | Done    |
| ✅ Xem điểm                | Planned |
| ✅ Nhập điểm               | Planned |
| ✅ Xem lớp học             | Planned |
| ✅ Xem lịch học            | Planned |

### **KHÔNG được:**

❌ Sửa thông tin sinh viên
❌ Sửa điểm
❌ Tạo/Sửa lịch học

---

# 🎓 7. SINH VIÊN

## **Vai trò:**

Sinh viên tra cứu thông tin cá nhân

## **Quyền hạn:** 2/30 quyền (7%)

### **Chức năng:**

| Chức năng                  | Status  |
| -------------------------- | ------- |
| ✅ Xem điểm (của mình)     | Planned |
| ✅ Xem lịch học (của mình) | Planned |
| ✅ Xem hồ sơ cá nhân       | Done    |
| ✅ Cập nhật ảnh đại diện   | Done    |
| ✅ Đăng ký học phần        | Planned |
| ✅ Xem học phí             | Planned |
| ✅ Chat với AI             | Planned |

---

# 🤖 8. TÍNH NĂNG ĐẶC BIỆT

## **A. AI CHATBOT** 🤖

| Chức năng        | Mô tả                        | Priority | Status     |
| ---------------- | ---------------------------- | -------- | ---------- |
| Chat tư vấn      | Hỏi đáp về quy chế, lịch học | High     | 🔄 Planned |
| Knowledge Base   | Lưu trữ câu hỏi thường gặp   | High     | 🔄 Planned |
| Log conversation | Lưu lịch sử chat             | Medium   | 🔄 Planned |
| Admin quản lý    | Xem/Sửa knowledge base       | Medium   | 🔄 Planned |

## **B. ĐĂNG KÝ HỌC PHẦN** 📝

| Chức năng               | Mô tả                        | Priority | Status     |
| ----------------------- | ---------------------------- | -------- | ---------- |
| Xem môn học             | Danh sách môn mở đăng ký     | High     | 🔄 Planned |
| Đăng ký                 | SV đăng ký môn học           | High     | 🔄 Planned |
| Hủy đăng ký             | Hủy trong thời gian cho phép | Medium   | 🔄 Planned |
| Kiểm tra trùng lịch     | Kiểm tra tự động             | High     | 🔄 Planned |
| Kiểm tra môn tiên quyết | Validate điều kiện           | High     | 🔄 Planned |

## **C. QUẢN LÝ HỌC PHÍ** 💰

| Chức năng    | Mô tả                  | Priority | Status     |
| ------------ | ---------------------- | -------- | ---------- |
| Xem học phí  | SV xem học phí từng kỳ | High     | 🔄 Planned |
| Lịch sử đóng | Lịch sử thanh toán     | Medium   | 🔄 Planned |
| Thông báo    | Nhắc nhở đóng học phí  | High     | 🔄 Planned |
| Báo cáo      | Admin xem thống kê thu | High     | 🔄 Planned |

## **D. ĐIỂM DANH** ✅

| Chức năng | Mô tả                      | Priority | Status     |
| --------- | -------------------------- | -------- | ---------- |
| Điểm danh | GV điểm danh sinh viên     | High     | 🔄 Planned |
| QR Code   | Sinh viên check-in bằng QR | High     | 🔄 Planned |
| Báo cáo   | Thống kê tỷ lệ vắng        | Medium   | 🔄 Planned |

---

# 📊 TIẾN ĐỘ TỔNG QUAN

## **Đã hoàn thành:** ✅

-   ✅ Hệ thống đăng nhập/đăng xuất
-   ✅ Phân quyền đầy đủ (7 vai trò, 30 quyền)
-   ✅ Quản lý người dùng (CRUD)
-   ✅ Quản lý sinh viên (CRUD)
-   ✅ Quản lý giảng viên (CRUD)
-   ✅ Quản lý đào tạo (CRUD)
-   ✅ Hồ sơ cá nhân (View, Update Avatar)
-   ✅ Database ERD hoàn chỉnh

## **Đang làm:** 🔄

-   Chưa có (vừa hoàn thành phân quyền)

## **Kế hoạch tiếp theo:** 📝

1. **Quản lý Danh mục** (Khoa, Ngành, Môn học, Phòng học)
2. **Quản lý Lớp học phần**
3. **Quản lý Điểm**
4. **Đăng ký học phần**
5. **Lịch học**
6. **AI Chatbot**
7. **Báo cáo & Thống kê**

---

# 🎯 PRIORITY ROADMAP

## **Phase 1: Core System** (Đã xong ✅)

-   [x] Authentication & Authorization
-   [x] User Management
-   [x] Student Management
-   [x] Teacher Management
-   [x] Profile Management

## **Phase 2: Academic Management** (Tiếp theo)

-   [ ] Department/Major/Subject Management
-   [ ] Class Management
-   [ ] Schedule Management
-   [ ] Grade Management

## **Phase 3: Student Services**

-   [ ] Course Registration
-   [ ] Tuition Management
-   [ ] Attendance System

## **Phase 4: Advanced Features**

-   [ ] AI Chatbot
-   [ ] Reports & Analytics
-   [ ] Notifications
-   [ ] Mobile App API

---

# 📞 LIÊN HỆ

**Project:** S-MIS (Student Management Information System)
**Version:** 1.0.0
**Tech Stack:** Laravel 11 + MySQL + Bootstrap 5
**Last Updated:** October 11, 2025

---

**© 2025 S-MIS Project. All rights reserved.**
