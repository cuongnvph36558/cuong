<?php

namespace App\Support;

use App\Models\SiteSetting;
use Normalizer;

/**
 * Single source of truth for the editable content of the landing page.
 *
 * The schema describes every editable field together with its default value,
 * so the admin form and the fallback content can never drift apart.
 */
class HomeContent
{
    /**
     * The database key holding the landing page content.
     */
    public const STORAGE_KEY = 'home_content';

    /**
     * Describe every editable section of the landing page.
     *
     * @return array<int, array<string, mixed>>
     */
    public static function schema(): array
    {
        return [
            [
                'key' => 'seo',
                'label' => 'SEO & Thẻ meta',
                'icon' => 'search',
                'description' => 'Tiêu đề và mô tả hiển thị khi bà con chia sẻ trang chủ.',
                'fields' => [
                    [
                        'key' => 'title',
                        'label' => 'Tiêu đề trang',
                        'type' => 'text',
                        'default' => 'Phân Bón ELICPO Thế Hệ Mới - Kích Rễ Mạnh, Đi Đọt Nhanh, Siêu Đậu Trái',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả trang',
                        'type' => 'textarea',
                        'default' => 'Phân bón hữu cơ ELICPO thế hệ mới: kích rễ mạnh, đi đọt nhanh, siêu đậu trái. Chất hữu cơ 20% Amino Acid từ đạm cá, rong biển. Dùng tốt cho rau màu, cây ăn trái, hoa và cây cảnh.',
                    ],
                ],
            ],
            [
                'key' => 'hero',
                'label' => 'Banner đầu trang',
                'icon' => 'sparkles',
                'description' => 'Phần đầu tiên bà con nhìn thấy: thương hiệu, tên sản phẩm, giá và nút bấm.',
                'fields' => [
                    [
                        'key' => 'brandName',
                        'label' => 'Tên thương hiệu',
                        'type' => 'text',
                        'default' => 'ELICPO',
                    ],
                    [
                        'key' => 'brandTagline',
                        'label' => 'Dòng phụ thương hiệu',
                        'type' => 'text',
                        'default' => 'Dinh dưỡng hữu cơ cho cây trồng',
                    ],
                    [
                        'key' => 'brandLetter',
                        'label' => 'Chữ trong ô logo',
                        'type' => 'text',
                        'default' => 'E',
                    ],
                    [
                        'key' => 'navPhone',
                        'label' => 'Số điện thoại trên thanh menu',
                        'type' => 'text',
                        'default' => '0973.42.6704',
                    ],
                    [
                        'key' => 'navCtaLabel',
                        'label' => 'Nút menu',
                        'type' => 'text',
                        'default' => 'Nhận tư vấn',
                    ],
                    [
                        'key' => 'badgeText',
                        'label' => 'Nhãn nổi bật',
                        'type' => 'text',
                        'default' => 'Thế Hệ Mới - Kích Rễ Mạnh - Đi Đọt Nhanh - Siêu Đậu Trái',
                    ],
                    [
                        'key' => 'titlePrefix',
                        'label' => 'Dòng tiêu đề 1',
                        'type' => 'text',
                        'default' => 'PHÂN BÓN',
                    ],
                    [
                        'key' => 'titleAccent',
                        'label' => 'Từ nhấn màu trong tiêu đề',
                        'type' => 'text',
                        'default' => 'ELICPO',
                    ],
                    [
                        'key' => 'titleSubtitle',
                        'label' => 'Dòng tiêu đề 2',
                        'type' => 'text',
                        'default' => 'Thế Hệ Mới - Kích Rễ Mạnh, Đi Đọt Nhanh, Siêu Đậu Trái',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Đoạn giới thiệu',
                        'type' => 'textarea',
                        'default' => 'Dung tịch dinh dưỡng hữu cơ từ đạm cá, amino acid và vi chất chelate. Kích rễ mạnh, đi đọt nhanh, siêu đậu trái cho vườn cây của bà con.',
                    ],
                    [
                        'key' => 'primaryCtaLabel',
                        'label' => 'Nút chính',
                        'type' => 'text',
                        'default' => 'NHẬN TƯ VẤN NGAY',
                    ],
                    [
                        'key' => 'primaryCtaHref',
                        'label' => 'Liên kết nút chính',
                        'type' => 'text',
                        'default' => '#dat-hang',
                    ],
                    [
                        'key' => 'secondaryCtaLabel',
                        'label' => 'Nút phụ',
                        'type' => 'text',
                        'default' => 'Xem liều lượng',
                    ],
                    [
                        'key' => 'secondaryCtaHref',
                        'label' => 'Liên kết nút phụ',
                        'type' => 'text',
                        'default' => '#huong-dan',
                    ],
                    [
                        'key' => 'features',
                        'label' => 'Các ô điểm nổi bật',
                        'type' => 'list',
                        'itemLabel' => 'Điểm nổi bật',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => '20% CHẤT HỮU CƠ'],
                            ['value' => '10% AMINO ACID'],
                            ['value' => '12% TỶ LỆ C/N'],
                            ['value' => 'pH H₂O 5.5'],
                            ['value' => 'DÙNG CHO NHIỀU LOẠI CÂY'],
                            ['value' => 'DẠNG LỎNG'],
                        ],
                    ],
                    [
                        'key' => 'productImage',
                        'label' => 'Ảnh sản phẩm',
                        'type' => 'image',
                        'default' => '/images/elicpo/product.png',
                    ],
                    [
                        'key' => 'productBadgeTitle',
                        'label' => 'Tiêu đề khung ảnh',
                        'type' => 'text',
                        'default' => 'Phân bón hữu cơ dạng lỏng',
                    ],
                    [
                        'key' => 'productBadgeText',
                        'label' => 'Nội dung khung ảnh',
                        'type' => 'textarea',
                        'default' => 'Dùng được cho rau màu, cây ăn trái, hoa và cây cảnh.',
                    ],
                    [
                        'key' => 'floatingBadgeValue',
                        'label' => 'Số trên tem nổi',
                        'type' => 'text',
                        'default' => '3X',
                    ],
                    [
                        'key' => 'floatingBadgeLabel',
                        'label' => 'Chữ trên tem nổi',
                        'type' => 'text',
                        'default' => 'Hiệu quả gấp 3',
                    ],
                ],
            ],
            [
                'key' => 'flashSale',
                'label' => 'Cam kết hiệu quả',
                'icon' => 'timer',
                'description' => 'Cam kết hiệu quả và thời hạn của sản phẩm.',
                'fields' => [
                    [
                        'key' => 'eyebrow',
                        'label' => 'Nhãn trên khối cam kết',
                        'type' => 'text',
                        'default' => 'Cam kết hiệu quả',
                    ],
                    [
                        'key' => 'price',
                        'label' => 'Dòng cam kết chính',
                        'type' => 'text',
                        'default' => 'Rễ MẠNH',
                    ],
                    [
                        'key' => 'originalPrice',
                        'label' => 'Dòng cam kết phụ (gạch ngang)',
                        'type' => 'text',
                        'default' => '',
                    ],
                    [
                        'key' => 'discount',
                        'label' => 'Nhãn nổi bật cạnh giá',
                        'type' => 'text',
                        'default' => 'MỚI',
                    ],
                    [
                        'key' => 'countdownLabel',
                        'label' => 'Nhãn đếm ngược',
                        'type' => 'text',
                        'default' => 'Đang có chương trình dùng thử',
                    ],
                    [
                        'key' => 'giftOffer',
                        'label' => 'Ưu đãi tặng kèm',
                        'type' => 'text',
                        'default' => 'Tặng 100 chai dùng thử giá ưu đãi',
                    ],
                    [
                        'key' => 'effectivenessDays',
                        'label' => 'Số ngày cam kết hiệu quả',
                        'type' => 'text',
                        'default' => 'Cam kết hiệu quả sau 5 - 7 ngày',
                    ],
                    [
                        'key' => 'effectivenessMultiplier',
                        'label' => 'Hệ số hiệu quả nổi bật',
                        'type' => 'text',
                        'default' => 'X100 LẦN',
                    ],
                    [
                        'key' => 'totalUsers',
                        'label' => 'Số người đã sử dụng',
                        'type' => 'text',
                        'default' => '3.826.534 người đã sử dụng và cho ra hiệu quả năng suất vượt trội',
                    ],
                    [
                        'key' => 'durationHours',
                        'label' => 'Số giờ của đồng hồ đếm ngược',
                        'type' => 'number',
                        'default' => 15,
                    ],
                    [
                        'key' => 'urgencyText',
                        'label' => 'Dòng kêu gọi hành động',
                        'type' => 'text',
                        'default' => 'Liên hệ ngay để được tư vấn liều lượng phù hợp',
                    ],
                    [
                        'key' => 'stockNote',
                        'label' => 'Ghi chú tồn kho',
                        'type' => 'text',
                        'default' => 'Số lượng có hạn trong đợt này.',
                    ],
                ],
            ],
            [
                'key' => 'variants',
                'label' => 'Quy cách sản phẩm',
                'icon' => 'package',
                'description' => 'Các quy cách (1L, 5L) bà con có thể chọn khi đặt hàng.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Quy cách 1L • 5L dùng cho nhiều loại cây',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Chọn quy cách phù hợp với diện tích vườn của bà con.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các quy cách',
                        'type' => 'list',
                        'itemLabel' => 'Quy cách',
                        'itemFields' => [
                            [
                                'key' => 'name',
                                'label' => 'Tên quy cách',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'badge',
                                'label' => 'Nhãn riêng',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'name' => 'Chai 1 lít',
                                'badge' => 'Dùng thử',
                                'description' => 'Phù hợp vườn nhỏ, cây trồng thử nghiệm hoặc bón định kỳ.',
                                'image' => '/images/elicpo/product.png',
                            ],
                            [
                                'name' => 'Can 5 lít',
                                'badge' => 'Tiết kiệm nhất',
                                'description' => 'Phù hợp vườn lớn, cây ăn trái và bón theo mùa.',
                                'image' => '/images/elicpo/banner.png',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'benefits',
                'label' => 'Công dụng nổi bật',
                'icon' => 'trophy',
                'description' => 'Ba công dụng chính của sản phẩm.',
                'fields' => [
                    [
                        'key' => 'eyebrow',
                        'label' => 'Dòng nhỏ phía trên',
                        'type' => 'text',
                        'default' => '3 công dụng nổi bật',
                    ],
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Kích Rễ Mạnh - Đi Đọt Nhanh - Siêu Đậu Trái',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các công dụng',
                        'type' => 'list',
                        'itemLabel' => 'Công dụng',
                        'itemFields' => [
                            [
                                'key' => 'title',
                                'label' => 'Tiêu đề',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'title' => 'Kích rễ mạnh',
                                'description' => 'Hỗ trợ bộ rễ ra rễ mới liên tục, hút dinh dưỡng nhanh hơn.',
                                'image' => '/images/elicpo/feature1.png',
                            ],
                            [
                                'title' => 'Đi đọt nhanh',
                                'description' => 'Đâm chồi, bung đọt mạnh chỉ sau 3 - 5 ngày sử dụng.',
                                'image' => '/images/elicpo/effect2.png',
                            ],
                            [
                                'title' => 'Siêu đậu trái',
                                'description' => 'Nuôi hoa, nuôi trái giúp cây đậu quả đều và nặng ký.',
                                'image' => '/images/elicpo/effect3.png',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'gallery',
                'label' => 'Thư viện ảnh',
                'icon' => 'images',
                'description' => 'Bộ sưu tập hình ảnh sản phẩm và vườn cây hiển thị trên trang chủ.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Hình ảnh thực tế sản phẩm ELICPO',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Bấm vào ảnh để xem phóng to hình ảnh sản phẩm và vườn cây thực tế của bà con.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các ảnh',
                        'type' => 'list',
                        'itemLabel' => 'Ảnh',
                        'itemFields' => [
                            [
                                'key' => 'image',
                                'label' => 'Ảnh',
                                'type' => 'image',
                            ],
                            [
                                'key' => 'title',
                                'label' => 'Tiêu đề',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                        ],
                        'default' => [
                            [
                                'image' => '/images/elicpo/product.png',
                                'title' => 'Sản phẩm ELICPO',
                                'description' => 'Chai phân bón hữu cơ dạng lỏng, dùng được cho mọi loại cây.',
                            ],
                            [
                                'image' => '/images/elicpo/banner.png',
                                'title' => 'Banner sản phẩm',
                                'description' => 'Hình ảnh quảng bá chính của sản phẩm.',
                            ],
                            [
                                'image' => '/images/elicpo/feature1.png',
                                'title' => 'Kích rễ mạnh',
                                'description' => 'Bộ rễ phát triển liên tục sau 3 - 5 ngày sử dụng.',
                            ],
                            [
                                'image' => '/images/elicpo/effect2.png',
                                'title' => 'Đi đọt nhanh',
                                'description' => 'Chồi non đâm mạnh, tán cây phát triển nhanh chóng.',
                            ],
                            [
                                'image' => '/images/elicpo/effect3.png',
                                'title' => 'Siêu đậu trái',
                                'description' => 'Cây ra hoa đều, quả to và nặng ký.',
                            ],
                            [
                                'image' => '/images/elicpo/label.png',
                                'title' => 'Nhãn sản phẩm',
                                'description' => 'Thông tin dinh dưỡng và hướng dẫn sử dụng trên bao bì.',
                            ],
                            [
                                'image' => '/images/elicpo/effect1.png',
                                'title' => 'Vi lượng chelate',
                                'description' => 'Siêu vi lượng chelate mạnh gấp 10 lần thông thường.',
                            ],
                            [
                                'image' => '/images/elicpo/cta1.jpg',
                                'title' => 'Vườn cây thực tế',
                                'description' => 'Hình ảnh vườn cây sau khi sử dụng sản phẩm.',
                            ],
                            [
                                'image' => '/images/elicpo/cta2.jpg',
                                'title' => 'Nhà vườn 1',
                                'description' => 'Cảm nhận của anh chị sau khi dùng phân bón ELICPO.',
                            ],
                            [
                                'image' => '/images/elicpo/cta3.jpg',
                                'title' => 'Nhà vườn 2',
                                'description' => 'Cảm nhận của anh chị sau khi dùng phân bón ELICPO.',
                            ],
                            [
                                'image' => '/images/elicpo/tech.png',
                                'title' => 'Công nghệ Nano',
                                'description' => 'Công nghệ Nano giúp hấp thu nhanh gấp 100 lần.',
                            ],
                            [
                                'image' => '/images/elicpo/tech1.png',
                                'title' => 'Dinh dưỡng chelate',
                                'description' => 'Vi chất chelate giúp cây hấp thu dinh dưỡng trọn vẹn.',
                            ],
                            [
                                'image' => '/images/elicpo/testimonial1.jpg',
                                'title' => 'Cảm nhận nhà vườn',
                                'description' => 'Anh Hùng chủ trại cà phê chia sẻ hiệu quả sau khi dùng thử.',
                            ],
                            [
                                'image' => '/images/elicpo/user/user1.png',
                                'title' => 'Khách hàng ELICPO',
                                'description' => 'Khách hàng đã tin dùng và giới thiệu bạn bè.',
                            ],
                            [
                                'image' => '/images/elicpo/user/user2.png',
                                'title' => 'Khách hàng ELICPO',
                                'description' => 'Khách hàng đã tin dùng và giới thiệu bạn bè.',
                            ],
                            [
                                'image' => '/images/elicpo/japan.webp',
                                'title' => 'Nguồn gốc nguyên liệu',
                                'description' => 'Nguyên liệu đạm cá và rong biển chọn lọc từ nguồn uy tín.',
                            ],
                            [
                                'image' => '/images/elicpo/certs.png',
                                'title' => 'Chứng nhận chất lượng',
                                'description' => 'Sản phẩm được kiểm nghiệm và chứng nhận đạt chuẩn.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'plantTypes',
                'label' => 'Loại cây trồng',
                'icon' => 'leaf',
                'description' => 'Danh sách cây trồng mà sản phẩm áp dụng được.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Phù hợp nhiều loại cây',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Dùng theo hướng dẫn trên nhãn, tùy từng loại cây và giai đoạn sinh trưởng.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các loại cây',
                        'type' => 'list',
                        'itemLabel' => 'Loại cây',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Tên loại cây',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'value' => 'Rau màu',
                                'image' => '/images/elicpo/effect1.png',
                            ],
                            [
                                'value' => 'Cây ăn trái',
                                'image' => '/images/elicpo/effect2.png',
                            ],
                            [
                                'value' => 'Hoa, cây cảnh',
                                'image' => '/images/elicpo/effect3.png',
                            ],
                            [
                                'value' => 'Cây thân gỗ',
                                'image' => '/images/elicpo/effect4.png',
                            ],
                            [
                                'value' => 'Cây bonsai',
                                'image' => '/images/elicpo/tech.png',
                            ],
                            [
                                'value' => 'Cây rau, củ',
                                'image' => '/images/elicpo/tech1.png',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'dosage',
                'label' => 'Hướng dẫn & liều lượng',
                'icon' => 'beaker',
                'description' => 'Liều lượng pha theo từng giai đoạn sinh trưởng.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Hướng dẫn sử dụng',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Pha phân bón ELICPO cùng 20 lít nước, điều chỉnh liều lượng theo từng giai đoạn phát triển của cây.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các giai đoạn',
                        'type' => 'list',
                        'itemLabel' => 'Giai đoạn',
                        'itemFields' => [
                            [
                                'key' => 'stage',
                                'label' => 'Tên giai đoạn',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'dosage',
                                'label' => 'Liều lượng',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                        ],
                        'default' => [
                            [
                                'stage' => 'Giai đoạn cây con',
                                'dosage' => '30 – 50ml / 20 lít nước',
                                'description' => 'Hỗ trợ phát triển rễ và thân lá.',
                            ],
                            [
                                'stage' => 'Giai đoạn trước ra hoa',
                                'dosage' => '70 – 100ml / 20 lít nước',
                                'description' => 'Bổ sung dinh dưỡng trước khi ra hoa.',
                            ],
                            [
                                'stage' => 'Mang trái & phục hồi',
                                'dosage' => '80 – 100ml / 20 lít nước',
                                'description' => 'Dùng khi cây mang trái hoặc sau thu hoạch.',
                            ],
                        ],
                    ],
                    [
                        'key' => 'tips',
                        'label' => 'Mẹo tưới & thời điểm',
                        'type' => 'list',
                        'itemLabel' => 'Mẹo',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Tưới ướt đẫm vùng rễ cây.'],
                            ['value' => 'Sử dụng định kỳ 10 – 15 ngày/lần.'],
                            ['value' => 'Tưới vào sáng sớm hoặc chiều tối.'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'ingredients',
                'label' => 'Thành phần & dinh dưỡng',
                'icon' => 'flask-conical',
                'description' => 'Công thức dinh dưỡng và các chỉ số phân tích của sản phẩm.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Dinh dưỡng & nguyên liệu',
                    ],
                    [
                        'key' => 'organicPercent',
                        'label' => 'Tỷ lệ chất hữu cơ',
                        'type' => 'text',
                        'default' => '20%',
                    ],
                    [
                        'key' => 'fishPercent',
                        'label' => 'Tỷ lệ nguyên liệu đạm cá',
                        'type' => 'text',
                        'default' => '45%',
                    ],
                    [
                        'key' => 'aminoPercent',
                        'label' => 'Tỷ lệ amino acid',
                        'type' => 'text',
                        'default' => '10%',
                    ],
                    [
                        'key' => 'cnRatio',
                        'label' => 'Tỷ lệ C/N',
                        'type' => 'text',
                        'default' => '12%',
                    ],
                    [
                        'key' => 'ph',
                        'label' => 'Độ pH H₂O',
                        'type' => 'text',
                        'default' => '5.5',
                    ],
                    [
                        'key' => 'supplements',
                        'label' => 'Dưỡng chất bổ sung',
                        'type' => 'list',
                        'itemLabel' => 'Chất bổ sung',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Tên chất',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Vitamin C'],
                            ['value' => 'Vitamin B6'],
                            ['value' => 'Tryptophan'],
                            ['value' => 'Rong biển'],
                            ['value' => 'Chlomequat Chloride'],
                            ['value' => 'Auxin'],
                        ],
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các thành phần',
                        'type' => 'list',
                        'itemLabel' => 'Thành phần',
                        'itemFields' => [
                            [
                                'key' => 'title',
                                'label' => 'Tiêu đề',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'title' => 'Siêu Vi Lượng Chelate',
                                'description' => 'Dòng siêu vi lượng này mạnh gấp 10 lần so với các dòng vi lượng thông thường.',
                                'image' => '/images/elicpo/effect1.png',
                            ],
                            [
                                'title' => 'Công nghệ Nano',
                                'description' => 'Giúp các phân tử Nano Đạm, Nano Lân, Nano Kali hấp thu nhanh gấp 100 lần.',
                                'image' => '/images/elicpo/effect2.png',
                            ],
                            [
                                'title' => 'Amino acid',
                                'description' => 'Từ rong biển, bột cá, tảo biển, bột thịt giúp cung cấp hơn 50 loại amino acid.',
                                'image' => '/images/elicpo/effect3.png',
                            ],
                            [
                                'title' => 'Acid humic, Acid Fulvic',
                                'description' => 'Giúp hệ rễ của cây trồng phát triển cực kì mạnh mẽ.',
                                'image' => '/images/elicpo/effect4.png',
                            ],
                        ],
                    ],
                    [
                        'key' => 'footerText',
                        'label' => 'Dòng kết section',
                        'type' => 'text',
                        'default' => 'Hiệu quả gấp 10 lần',
                    ],
                ],
            ],
            [
                'key' => 'problemSelector',
                'label' => 'Chọn tình trạng cây',
                'icon' => 'tags',
                'description' => 'Các ô chọn tình trạng cây mà bà con hay gặp.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Bạn đang gặp tình trạng nào?',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các tình trạng',
                        'type' => 'list',
                        'itemLabel' => 'Tình trạng',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'VÀNG LÁ'],
                            ['value' => 'THỐI RỂ'],
                            ['value' => 'CÂY CÒI CỌC'],
                            ['value' => 'CÂY SÂU BỆNH'],
                            ['value' => 'KHÔNG RA HOA'],
                            ['value' => 'CÂY HÉO ÚA'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'combos',
                'label' => 'Combo ưu đãi',
                'icon' => 'gift',
                'description' => 'Các combo mua nhiều tặng nhiều quà.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Chọn combo phân bón ELICPO',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Mua càng nhiều, quà càng lớn.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các combo',
                        'type' => 'list',
                        'itemLabel' => 'Combo',
                        'itemFields' => [
                            [
                                'key' => 'name',
                                'label' => 'Tên combo',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'gift',
                                'label' => 'Quà tặng',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'badge',
                                'label' => 'Nhãn riêng',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            [
                                'name' => 'Combo 1 chai 1 lít',
                                'gift' => 'Tặng 3 Nano Kali + 1 lọ kích rễ TC01 · FREESHIP',
                                'badge' => 'Combo dùng thử',
                            ],
                            [
                                'name' => 'Combo 2 chai 2 lít',
                                'gift' => 'Tặng 5 Nano Kali + 1 lọ TC01 · FREESHIP',
                                'badge' => '',
                            ],
                            [
                                'name' => 'Combo 3 chai 3 lít',
                                'gift' => 'Tặng 7 Nano Kali + 1 lọ TC01 · FREESHIP',
                                'badge' => '',
                            ],
                            [
                                'name' => 'Combo 1 can 5 lít',
                                'gift' => 'Tặng 10 Nano Kali + 1 lọ TC01 · FREESHIP',
                                'badge' => 'Combo nhà vườn',
                            ],
                            [
                                'name' => 'Combo 2 can 5 lít',
                                'gift' => 'Tặng 15 Nano Kali + 2 lọ kích rễ TC01 · FREESHIP',
                                'badge' => 'Bán chạy nhất',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'testimonials',
                'label' => 'Cảm nhận khách hàng',
                'icon' => 'quote',
                'description' => 'Các đánh giá của bà con nông dân sau khi dùng sản phẩm.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Bà con nông dân sau khi sử dụng sản phẩm',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Cảm nhận',
                        'type' => 'list',
                        'itemLabel' => 'Cảm nhận',
                        'itemFields' => [
                            [
                                'key' => 'quote',
                                'label' => 'Nội dung cảm nhận',
                                'type' => 'textarea',
                            ],
                            [
                                'key' => 'author',
                                'label' => 'Tên người gửi',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh đại diện',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'quote' => 'Tôi đã dùng rất nhiều loại phân bón khác nhau, nhưng để hiệu quả nhanh nhất thì có lẽ là phân bón ELICPO. Hiệu quả rất nhanh mà lại dễ dùng.',
                                'author' => 'Anh Hùng chủ trại Cà Phê Gia Lai',
                                'image' => '/images/elicpo/testimonial1.jpg',
                            ],
                            [
                                'quote' => 'Rất cảm ơn sản phẩm đã cứu sống vườn cây của tôi. Ban đầu thấy quảng cáo thì cũng mua thử dùng trước cho vài gốc, ai ngờ hiệu quả nhanh thật sự.',
                                'author' => 'Anh Trần Hùng chủ trại bưởi ở Vĩnh Long',
                                'image' => '/images/elicpo/cta3.jpg',
                            ],
                            [
                                'quote' => 'Tôi cũng chỉ vô tình được bà con tặng cho 1 lọ dùng thử, nhưng đúng là hiệu quả khác xa so với những loại phân bón trước đây tôi từng sử dụng, tôi mới đặt thêm 2 thùng về dùng cho toàn bộ vườn cây.',
                                'author' => 'Anh Việt Vương chủ trại ở Lâm Đồng',
                                'image' => '/images/elicpo/cta2.jpg',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'reviews',
                'label' => 'Đánh giá khách hàng',
                'icon' => 'star',
                'description' => 'Bảng điểm đánh giá và các bình luận chi tiết.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Khách hàng đánh giá về sản phẩm',
                    ],
                    [
                        'key' => 'averageRating',
                        'label' => 'Điểm trung bình',
                        'type' => 'number',
                        'default' => 5,
                    ],
                    [
                        'key' => 'totalReviews',
                        'label' => 'Số nhận xét',
                        'type' => 'text',
                        'default' => '1.545 nhận xét',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các bình luận',
                        'type' => 'list',
                        'itemLabel' => 'Bình luận',
                        'itemFields' => [
                            [
                                'key' => 'name',
                                'label' => 'Tên người đánh giá',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'time',
                                'label' => 'Thời gian',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'content',
                                'label' => 'Nội dung',
                                'type' => 'textarea',
                            ],
                        ],
                        'default' => [
                            [
                                'name' => 'Hảo Lâm',
                                'time' => '5 tiếng trước',
                                'content' => 'Dùng rất tuyệt vời. Chất lượng đúng mô tả cảm ơn shop rất nhiều.',
                            ],
                            [
                                'name' => 'Văn Long',
                                'time' => '45 phút trước',
                                'content' => 'Thích cái là hàng trực tiếp từ nhà máy nên cũng yên tâm. Xài mấy ngày là thấy rễ với đọt ra rồi.',
                            ],
                            [
                                'name' => 'Kim Hậu',
                                'time' => '1 giờ trước',
                                'content' => 'Nhà mình có vườn sầu, mua 1 thùng về dùng thử, hiệu quả lắm, mà mua theo thùng thì được chiết khấu ưu đãi nữa.',
                            ],
                            [
                                'name' => 'Kim Lan',
                                'time' => '1 tiếng trước',
                                'content' => 'Vườn tui có mấy cây ăn trái năm đầu xong bị chết đọt, vàng lá mình sử dụng loại này thấy ok lắm.',
                            ],
                            [
                                'name' => 'Uyên Trần',
                                'time' => '2 tiếng trước',
                                'content' => 'Cái này mua theo vườn bên cạnh thấy cây tốt mà ra hoa cũng đậu quả nhiều.',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'problems',
                'label' => 'Vấn đề & cách khắc phục',
                'icon' => 'alert-triangle',
                'description' => 'Các tình trạng cây thường gặp và kết quả sau khi dùng ELICPO.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Bà con đang đau đầu về điều gì?',
                    ],
                    [
                        'key' => 'warningTitle',
                        'label' => 'Tiêu đề cảnh báo',
                        'type' => 'text',
                        'default' => 'CẢNH BÁO!',
                    ],
                    [
                        'key' => 'warningText',
                        'label' => 'Nội dung cảnh báo',
                        'type' => 'textarea',
                        'default' => 'Cây khó kích rễ, kích đọt và chậm đẻ nhánh chủ yếu do đất trồng nghèo dinh dưỡng, chai cứng hoặc bị úng nước, khiến rễ không thể phát triển và hấp thu chất cần thiết. Nếu không có biện pháp cải thiện kịp thời, cây sẽ còi cọc, giảm năng suất.',
                    ],
                    [
                        'key' => 'solutionTitle',
                        'label' => 'Tiêu đề khối giải pháp',
                        'type' => 'text',
                        'default' => 'Chỉ 2 lần phun - Giải quyết ngay các vấn đề',
                    ],
                    [
                        'key' => 'solutionText',
                        'label' => 'Mô tả giải pháp',
                        'type' => 'textarea',
                        'default' => 'Chỉ cần 2 lần phun, tái sinh lại bộ rễ, hấp thu dinh dưỡng siêu tốt. Mầm, chồi khỏe mạnh, cây suy khoẻ lại thần kỳ.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các vấn đề',
                        'type' => 'list',
                        'itemLabel' => 'Vấn đề',
                        'itemFields' => [
                            [
                                'key' => 'title',
                                'label' => 'Tiêu đề',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'description',
                                'label' => 'Mô tả',
                                'type' => 'textarea',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh vấn đề',
                                'type' => 'image',
                            ],
                            [
                                'key' => 'resultImage',
                                'label' => 'Ảnh kết quả',
                                'type' => 'image',
                            ],
                            [
                                'key' => 'result',
                                'label' => 'Kết quả',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            [
                                'title' => 'Cây không ra đọt, ngừng phát triển',
                                'description' => 'Cây không ra đọt, thậm chí ngừng phát triển dù đã bón phân.',
                                'image' => '/images/elicpo/problem1.jpg',
                                'resultImage' => '/images/elicpo/effect1.png',
                                'result' => 'Kích rễ mạnh',
                            ],
                            [
                                'title' => 'Đất chai cứng, cây không bám rễ',
                                'description' => 'Đất trồng lâu năm bị chai, rễ không thể lấy dinh dưỡng, khiến cây còi cọc.',
                                'image' => '/images/elicpo/problem2.webp',
                                'resultImage' => '/images/elicpo/feature1.png',
                                'result' => 'Rễ phát triển',
                            ],
                            [
                                'title' => 'Cây héo rũ, rễ yếu, dễ chết',
                                'description' => 'Cây non nhưng rễ không phát triển, nhanh héo rũ, thậm chí chết cây.',
                                'image' => '/images/elicpo/problem3.png',
                                'resultImage' => '/images/elicpo/grow.gif',
                                'result' => 'Đi đọt nhanh',
                            ],
                            [
                                'title' => 'Cây thối rễ, cây suy kiệt',
                                'description' => 'Cây yếu, khó ra đọt thường bị nấm hại rễ, giâm cành nhưng không thành công.',
                                'image' => '/images/elicpo/problem4.jpg',
                                'resultImage' => '/images/elicpo/tech.png',
                                'result' => 'Chống nấm',
                            ],
                            [
                                'title' => 'Mất mùa, giảm năng suất',
                                'description' => 'Cây ra hoa không đạt, quả không đủ lớn, năng suất giảm mạnh.',
                                'image' => '/images/elicpo/problem5.webp',
                                'resultImage' => '/images/elicpo/effect3.png',
                                'result' => 'Siêu đậu trái',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'highlights',
                'label' => 'Cam kết & đặc tính',
                'icon' => 'badge-check',
                'description' => 'Các cam kết nổi bật về công nghệ và nguồn gốc.',
                'fields' => [
                    [
                        'key' => 'items',
                        'label' => 'Các cam kết',
                        'type' => 'list',
                        'itemLabel' => 'Cam kết',
                        'itemFields' => [
                            [
                                'key' => 'title',
                                'label' => 'Tiêu đề',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'value',
                                'label' => 'Giá trị',
                                'type' => 'text',
                            ],
                            [
                                'key' => 'image',
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'title' => 'Công nghệ tiên tiến',
                                'value' => 'CÔNG NGHỆ TIÊN TIẾN',
                                'image' => '/images/elicpo/tech.png',
                            ],
                            [
                                'title' => 'Vi lượng đầy đủ',
                                'value' => 'VI LƯỢNG ĐẦY ĐỦ',
                                'image' => '/images/elicpo/effect1.png',
                            ],
                            [
                                'title' => 'Axit humic 7%',
                                'value' => 'AXIT HUMIC 7%',
                                'image' => '/images/elicpo/tech1.png',
                            ],
                            [
                                'title' => 'Dạng lỏng',
                                'value' => 'DẠNG LỎNG',
                                'image' => '/images/elicpo/feature4.png',
                            ],
                            [
                                'title' => 'NPK 3-3-3',
                                'value' => 'NPK 3-3-3',
                                'image' => '/images/elicpo/feature2.png',
                            ],
                            [
                                'title' => 'Nguyên liệu Nhật Bản',
                                'value' => 'ĐƯỢC NGƯỜI NHẬT ĐÁNH GIÁ CAO',
                                'image' => '/images/elicpo/japan.webp',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'cta',
                'label' => 'Form đặt hàng',
                'icon' => 'clipboard-list',
                'description' => 'Nội dung quay cuốn và form đặt hàng nhanh.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Để lại thông tin, nhận tư vấn miễn phí',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Chỉ cần họ tên và số điện thoại. Kỹ sư nông nghiệp sẽ gọi xác nhận trong 15 phút.',
                    ],
                    [
                        'key' => 'benefits',
                        'label' => 'Các lợi ích',
                        'type' => 'list',
                        'itemLabel' => 'Lợi ích',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Giao nhanh 2 - 3 ngày'],
                            ['value' => 'Nhận voucher 15K nếu đơn giao trễ'],
                            ['value' => 'FREESHIP toàn quốc'],
                            ['value' => 'Đổi trả miễn phí trong 7 ngày'],
                        ],
                    ],
                    [
                        'key' => 'commitments',
                        'label' => 'Các cam kết',
                        'type' => 'list',
                        'itemLabel' => 'Cam kết',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Sản phẩm được kiểm nghiệm và chứng nhận, kiểm soát chặt chẽ về chất lượng.'],
                            ['value' => 'Hỗ trợ đổi trả trong 7 ngày.'],
                            ['value' => 'Đội ngũ tư vấn nông nghiệp tận tình, hỗ trợ bà con 24/7.'],
                        ],
                    ],
                    [
                        'key' => 'formTitle',
                        'label' => 'Tiêu đề form',
                        'type' => 'text',
                        'default' => 'Nhập tên và số điện thoại để được tư vấn',
                    ],
                    [
                        'key' => 'formSubtitle',
                        'label' => 'Mô tả form',
                        'type' => 'text',
                        'default' => 'Kỹ sư nông nghiệp sẽ liên hệ trực tiếp tư vấn miễn phí.',
                    ],
                    [
                        'key' => 'couponCode',
                        'label' => 'Mã giảm giá mặc định',
                        'type' => 'text',
                        'default' => 'ELICPO10',
                    ],
                    [
                        'key' => 'plantTypes',
                        'label' => 'Loại cây trong form',
                        'type' => 'list',
                        'itemLabel' => 'Loại cây',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Tên loại cây',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Rau màu'],
                            ['value' => 'Cây ăn trái'],
                            ['value' => 'Hoa, cây cảnh'],
                            ['value' => 'Cây thân gỗ'],
                            ['value' => 'Cây bonsai'],
                            ['value' => 'Cây rau, củ'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'finalCta',
                'label' => 'Kêu gọi cuối trang',
                'icon' => 'rocket',
                'description' => 'Mã ưu đãi và nút bấm cuối cùng của trang.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề',
                        'type' => 'textarea',
                        'default' => 'Cảm ơn bạn đã đăng ký!',
                    ],
                    [
                        'key' => 'couponLabel',
                        'label' => 'Nhãn mã ưu đãi',
                        'type' => 'text',
                        'default' => 'Nhập mã nhận ưu đãi',
                    ],
                    [
                        'key' => 'couponCode',
                        'label' => 'Mã ưu đãi',
                        'type' => 'text',
                        'default' => 'ELICPO10',
                    ],
                    [
                        'key' => 'peopleCount',
                        'label' => 'Số người đã đăng ký',
                        'type' => 'number',
                        'default' => 99,
                    ],
                    [
                        'key' => 'urgencyText',
                        'label' => 'Dòng kêu gọi hành động',
                        'type' => 'text',
                        'default' => 'Nhanh tay đặt hàng nhận ngay ưu đãi!',
                    ],
                    [
                        'key' => 'buttonLabel',
                        'label' => 'Nút bấm',
                        'type' => 'text',
                        'default' => 'Đặt hàng ngay',
                    ],
                    [
                        'key' => 'buttonHref',
                        'label' => 'Liên kết nút bấm',
                        'type' => 'text',
                        'default' => '#dat-hang',
                    ],
                ],
            ],
            [
                'key' => 'footer',
                'label' => 'Chân trang',
                'icon' => 'building-2',
                'description' => 'Thông tin công ty, liên kết và bản quyền.',
                'fields' => [
                    [
                        'key' => 'brandName',
                        'label' => 'Tên thương hiệu',
                        'type' => 'text',
                        'default' => 'ELICPO',
                    ],
                    [
                        'key' => 'companyName',
                        'label' => 'Tên công ty',
                        'type' => 'text',
                        'default' => 'CÔNG TY TNHH ELICPO VIỆT NAM',
                    ],
                    [
                        'key' => 'address',
                        'label' => 'Địa chỉ',
                        'type' => 'textarea',
                        'default' => 'Tầng 4 Toà TH OFFICE TOWER 18, Số 438 Đường Khương Đình, Phường Hạ Đình, Thanh Xuân, Hà Nội',
                    ],
                    [
                        'key' => 'hotline',
                        'label' => 'Hotline',
                        'type' => 'text',
                        'default' => '0973.42.6704',
                    ],
                    [
                        'key' => 'hotlineHref',
                        'label' => 'Liên kết hotline',
                        'type' => 'text',
                        'default' => 'tel:0973426704',
                    ],
                    [
                        'key' => 'plantListHeading',
                        'label' => 'Tiêu đề danh sách cây',
                        'type' => 'text',
                        'default' => 'Sử dụng trên nhiều loại cây',
                    ],
                    [
                        'key' => 'infoHeading',
                        'label' => 'Tiêu đề thông tin',
                        'type' => 'text',
                        'default' => 'Thông tin',
                    ],
                    [
                        'key' => 'infoLinks',
                        'label' => 'Các liên kết',
                        'type' => 'list',
                        'itemLabel' => 'Liên kết',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Thông báo về quyền riêng tư'],
                            ['value' => 'Thông báo cookies'],
                            ['value' => 'Điều khoản sử dụng'],
                            ['value' => 'Chính sách bảo mật'],
                        ],
                    ],
                    [
                        'key' => 'copyright',
                        'label' => 'Bản quyền',
                        'type' => 'text',
                        'default' => 'Copyright @ ELICPO - Tập Đoàn Phân Bón Hữu Cơ. All Rights Reserved',
                    ],
                ],
            ],
            [
                'key' => 'stickyCta',
                'label' => 'Thanh điện thoại (mobile)',
                'icon' => 'phone',
                'description' => 'Thanh nút cố định ở cuối màn hình trên điện thoại.',
                'fields' => [
                    [
                        'key' => 'callLabel',
                        'label' => 'Nút gọi',
                        'type' => 'text',
                        'default' => 'Gọi ngay',
                    ],
                    [
                        'key' => 'callHref',
                        'label' => 'Số điện thoại',
                        'type' => 'text',
                        'default' => 'tel:0973426704',
                    ],
                    [
                        'key' => 'registerLabel',
                        'label' => 'Nút đặt hàng',
                        'type' => 'text',
                        'default' => 'Đăng ký tư vấn',
                    ],
                    [
                        'key' => 'registerHref',
                        'label' => 'Liên kết đặt hàng',
                        'type' => 'text',
                        'default' => '#dat-hang',
                    ],
                ],
            ],
        ];
    }

    /**
     * Build the default content tree from the schema.
     *
     * @return array<string, mixed>
     */
    public static function defaults(): array
    {
        $content = [];

        foreach (static::schema() as $section) {
            $sectionContent = [];

            foreach ($section['fields'] as $field) {
                $sectionContent[$field['key']] = $field['default'];
            }

            $content[$section['key']] = $sectionContent;
        }

        return $content;
    }

    /**
     * Get the stored content merged on top of the defaults.
     *
     * @return array<string, mixed>
     */
    public static function get(): array
    {
        $stored = SiteSetting::value(static::STORAGE_KEY, []);
        $defaults = static::defaults();

        if (! is_array($stored)) {
            return $defaults;
        }

        $content = [];

        foreach ($defaults as $sectionKey => $sectionDefaults) {
            $storedSection = is_array($stored[$sectionKey] ?? null) ? $stored[$sectionKey] : [];
            $section = [];

            foreach ($sectionDefaults as $fieldKey => $defaultValue) {
                $value = $storedSection[$fieldKey] ?? $defaultValue;

                if (is_array($defaultValue) && ! is_array($value)) {
                    $value = $defaultValue;
                }

                $section[$fieldKey] = $value;
            }

            $content[$sectionKey] = $section;
        }

        return $content;
    }

    /**
     * Persist the content.
     *
     * @param  array<string, mixed>  $content
     */
    public static function store(array $content): void
    {
        SiteSetting::put(static::STORAGE_KEY, $content);
    }

    /**
     * Get the list of symptom labels used by the lead form.
     *
     * @return array<int, string>
     */
    public static function symptomOptions(): array
    {
        return array_values(array_filter(array_map(
            static fn (array $item): string => static::normalizeText((string) ($item['value'] ?? '')),
            static::get()['problemSelector']['items'] ?? [],
        )));
    }

    /**
     * Get the list of plant type labels used by the lead form.
     *
     * @return array<int, string>
     */
    public static function plantTypeOptions(): array
    {
        return array_values(array_filter(array_map(
            static fn (array $item): string => static::normalizeText((string) ($item['value'] ?? '')),
            static::get()['cta']['plantTypes'] ?? [],
        )));
    }

    /**
     * Get the list of product variants offered in the order form.
     *
     * @return array<int, string>
     */
    public static function variantOptions(): array
    {
        return array_values(array_filter(array_map(
            static fn (array $item): string => static::normalizeText((string) ($item['name'] ?? '')),
            static::get()['variants']['items'] ?? [],
        )));
    }

    /**
     * Convert a string to the composed Unicode form (NFC).
     *
     * Vietnamese text may be stored in the composed or the decomposed Unicode
     * form. Both represent the same string, so every label is normalised to
     * keep comparisons between stored options and submitted values reliable.
     */
    public static function normalizeText(string $value): string
    {
        if ($value === '' || ! class_exists(Normalizer::class)) {
            return $value;
        }

        return Normalizer::normalize($value, Normalizer::FORM_C) ?: $value;
    }
}
