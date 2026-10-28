<?php

namespace App\Support;

use App\Models\SiteSetting;

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
                        'default' => 'Phân bón ROOTBIO',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả trang',
                        'type' => 'textarea',
                        'default' => 'Phân bón sinh học ROOTBIO - kích rễ, bung đọt, hết vàng lá thối rễ chỉ sau 2 lần tưới. Nhận ưu đãi tặng 100 chai dùng thử.',
                    ],
                ],
            ],
            [
                'key' => 'hero',
                'label' => 'Banner đầu trang',
                'icon' => 'sparkles',
                'description' => 'Phần đầu tiên bà con nhìn thấy: thương hiệu, tiêu đề và nút bấm.',
                'fields' => [
                    [
                        'key' => 'brandName',
                        'label' => 'Tên thương hiệu',
                        'type' => 'text',
                        'default' => 'ROOTBIO',
                    ],
                    [
                        'key' => 'brandTagline',
                        'label' => 'Dòng phụ thương hiệu',
                        'type' => 'text',
                        'default' => 'Phân bón sinh học',
                    ],
                    [
                        'key' => 'brandLetter',
                        'label' => 'Chữ trong ô logo',
                        'type' => 'text',
                        'default' => 'R',
                    ],
                    [
                        'key' => 'navPhone',
                        'label' => 'Số điện thoại trên thanh menu',
                        'type' => 'text',
                        'default' => '0939.393.912',
                    ],
                    [
                        'key' => 'navCtaLabel',
                        'label' => 'Nút menu',
                        'type' => 'text',
                        'default' => 'Đăng ký ngay',
                    ],
                    [
                        'key' => 'badgeText',
                        'label' => 'Nhãn nổi bật',
                        'type' => 'text',
                        'default' => 'Nhận ưu đãi - Tặng 100 chai dùng thử',
                    ],
                    [
                        'key' => 'titlePrefix',
                        'label' => 'Dòng tiêu đề 1',
                        'type' => 'text',
                        'default' => 'Phân bón',
                    ],
                    [
                        'key' => 'titleAccent',
                        'label' => 'Từ nhấn màu trong tiêu đề',
                        'type' => 'text',
                        'default' => 'ROOTBIO',
                    ],
                    [
                        'key' => 'titleSubtitle',
                        'label' => 'Dòng tiêu đề 2',
                        'type' => 'text',
                        'default' => 'Chỉ 2 lần phun – cây bung đọt, ra rễ mạnh',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Đoạn giới thiệu',
                        'type' => 'textarea',
                        'default' => 'Cam kết hiệu quả sau 5 - 7 ngày. Công nghệ Nano đạt chuẩn Thụy Sỹ, vi lượng chelate mạnh gấp 10 lần, axit humic 7% và 7% Kali hữu hiệu giúp cây hết vàng lá, thối rễ, còi cọc.',
                    ],
                    [
                        'key' => 'primaryCtaLabel',
                        'label' => 'Nút chính',
                        'type' => 'text',
                        'default' => 'Nhận ưu đãi',
                    ],
                    [
                        'key' => 'primaryCtaHref',
                        'label' => 'Liên kết nút chính',
                        'type' => 'text',
                        'default' => '#dang-ky',
                    ],
                    [
                        'key' => 'secondaryCtaLabel',
                        'label' => 'Nút phụ',
                        'type' => 'text',
                        'default' => 'Xem hiệu quả',
                    ],
                    [
                        'key' => 'secondaryCtaHref',
                        'label' => 'Liên kết nút phụ',
                        'type' => 'text',
                        'default' => '#hieu-qua',
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
                            ['value' => 'cam kết hiệu quả sau 5 -7 ngày'],
                            ['value' => 'X100 LẦN'],
                            ['value' => 'CÔNG NGHỆ TIÊN TIẾN'],
                            ['value' => 'Vi lượng đầy đủ'],
                            ['value' => 'Axit Humic 7%'],
                            ['value' => 'Dạng lỏng'],
                            ['value' => 'NPK 3-3-3'],
                        ],
                    ],
                    [
                        'key' => 'productImage',
                        'label' => 'Ảnh sản phẩm',
                        'type' => 'image',
                        'default' => '/images/rootbio/product.png',
                    ],
                    [
                        'key' => 'productBadgeTitle',
                        'label' => 'Tiêu đề khung ảnh',
                        'type' => 'text',
                        'default' => 'Hiệu quả gấp 10 lần',
                    ],
                    [
                        'key' => 'productBadgeText',
                        'label' => 'Nội dung khung ảnh',
                        'type' => 'textarea',
                        'default' => 'Hơn 3.826.534 người đã sử dụng và cho ra hiệu quả năng suất vượt trội',
                    ],
                    [
                        'key' => 'floatingBadgeValue',
                        'label' => 'Số trên tem nổi',
                        'type' => 'text',
                        'default' => '100',
                    ],
                    [
                        'key' => 'floatingBadgeLabel',
                        'label' => 'Chữ trên tem nổi',
                        'type' => 'text',
                        'default' => 'Chai dùng thử',
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
                        'default' => 'Giải pháp an toàn cho mọi loại cây',
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
                        ],
                        'default' => [
                            ['value' => 'Cây thân gỗ'],
                            ['value' => 'Cây Bonsai'],
                            ['value' => 'Cây ăn quả'],
                            ['value' => 'Cây Rau, củ'],
                            ['value' => 'Các cây hoa'],
                            ['value' => 'Các cây cảnh'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'problems',
                'label' => 'Vấn đề bà con gặp',
                'icon' => 'triangle-alert',
                'description' => 'Các triệu chứng cây trồng hay gặp và cảnh báo.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Bà con đang đau đầu về điều gì?',
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
                                'label' => 'Ảnh minh hoạ',
                                'type' => 'image',
                            ],
                        ],
                        'default' => [
                            [
                                'title' => 'Cây không ra đọt, ngừng phát triển',
                                'description' => 'Cây không ra đọt, thậm chí ngừng phát triển dù đã bón phân.',
                                'image' => '/images/rootbio/problem3.png',
                            ],
                            [
                                'title' => 'Đất chai cứng, cây không bám rễ',
                                'description' => 'Đất trồng lâu năm bị chai, rễ không thể lấy dinh dưỡng, khiến cây còi cọc.',
                                'image' => '/images/rootbio/problem5.webp',
                            ],
                            [
                                'title' => 'Cây héo rũ, rễ yếu, dễ chết',
                                'description' => 'Cây non nhưng mà rễ không phát triển, nhanh héo rũ, thậm chí chết cây.',
                                'image' => '/images/rootbio/problem1.jpg',
                            ],
                            [
                                'title' => 'Cây thối rễ, cây suy kiệt',
                                'description' => 'Cây yếu, khó ra đọt thường bị nấm hại rễ, giâm cành nhưng không thành công.',
                                'image' => '/images/rootbio/problem4.jpg',
                            ],
                        ],
                    ],
                    [
                        'key' => 'warningTitle',
                        'label' => 'Tiêu đề cảnh báo',
                        'type' => 'text',
                        'default' => 'Cảnh báo!',
                    ],
                    [
                        'key' => 'warningText',
                        'label' => 'Nội dung cảnh báo',
                        'type' => 'textarea',
                        'default' => 'Cây khó kích rễ, kích đọt và chậm đẻ nhánh chủ yếu do đất trồng nghèo dinh dưỡng, chai cứng hoặc bị úng nước, khiến rễ không thể phát triển và hấp thu chất cần thiết. Ngoài ra, việc bón phân không cân đối, thiếu vi lượng quan trọng cũng làm cây suy yếu, khó ra đọt và chậm đẻ nhánh.',
                    ],
                    [
                        'key' => 'warningTags',
                        'label' => 'Các thẻ cảnh báo',
                        'type' => 'list',
                        'itemLabel' => 'Thẻ',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung thẻ',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'CÂY CÒI CỌC'],
                            ['value' => 'CÂY VÀNG LÁ'],
                            ['value' => 'CÂY THỐI RỄ'],
                            ['value' => 'ĐẤT BẠC MÀU'],
                            ['value' => 'MẤT MÙA, GIẢM NĂNG SUẤT'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'solutions',
                'label' => 'Hiệu quả & Lợi ích',
                'icon' => 'flask-conical',
                'description' => 'Các cam kết hiệu quả và con số thống kê.',
                'fields' => [
                    [
                        'key' => 'eyebrow',
                        'label' => 'Dòng nhỏ phía trên',
                        'type' => 'text',
                        'default' => 'Chỉ 2 lần phun',
                    ],
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Giải quyết ngay các vấn đề',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Chỉ cần 2 lần phun, tái sinh lại bộ rễ, hấp thu dinh dưỡng siêu tốt. Mầm, chồi khỏe mạnh, cây suy khoẻ lại thần kỳ.',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các cam kết hiệu quả',
                        'type' => 'list',
                        'itemLabel' => 'Cam kết',
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
                                'title' => 'HẾT Vàng Lá Thối Rễ sau 2 lần tưới',
                                'description' => 'Kích thích RA RỄ nhanh, cây tăng trưởng mạnh! Cây hấp thụ tối đa dưỡng chất, cây nhanh lớn, bung đọt mạnh, kích rễ nhanh phát triển gấp 5 lần sau 2 lần sử dụng nhờ 45% lượng axit humic có trong sản phẩm.',
                                'image' => '/images/rootbio/feature5.png',
                            ],
                            [
                                'title' => 'Đảm bảo tỷ lệ kích thích ra hoa, đậu quả lên tới 93%',
                                'description' => 'Chỉ sau 2 lần tưới với 7% Kali hữu hiệu. Tổng hợp các chất điều hòa sinh trưởng, kích thích quả, hoa, lá phát triển mạnh mẽ, tăng 30% chất lượng nông sản so với thông thường.',
                                'image' => '/images/rootbio/feature6.png',
                            ],
                            [
                                'title' => 'Tăng sức đề kháng với công nghệ Probiotics',
                                'description' => 'Ứng dụng công nghệ Probiotics cung cấp hàng tỷ lợi khuẩn cho cây và môi trường đất, tăng khả năng chống nấm bệnh và cải thiện chất đất.',
                                'image' => '/images/rootbio/tech1.png',
                            ],
                            [
                                'title' => 'Công nghệ Nano đạt chuẩn công nghệ Thụy Sỹ',
                                'description' => 'Giúp cây hấp thụ qua lá nhanh hơn, hiệu quả hơn gấp 3 lần so với bón gốc.',
                                'image' => '/images/rootbio/tech2.png',
                            ],
                        ],
                    ],
                    [
                        'key' => 'statsEyebrow',
                        'label' => 'Dòng dẫn thống kê',
                        'type' => 'text',
                        'default' => 'Theo thống kê lên đến hơn',
                    ],
                    [
                        'key' => 'statsValue',
                        'label' => 'Con số lớn',
                        'type' => 'number',
                        'default' => 3826534,
                    ],
                    [
                        'key' => 'statsValueLabel',
                        'label' => 'Chú thích con số lớn',
                        'type' => 'text',
                        'default' => 'người đã sử dụng và cho ra hiệu quả năng suất vượt trội',
                    ],
                    [
                        'key' => 'statsSecondaryValue',
                        'label' => 'Con số phụ',
                        'type' => 'number',
                        'default' => 99,
                    ],
                    [
                        'key' => 'statsSecondaryLabel',
                        'label' => 'Chú thích con số phụ',
                        'type' => 'text',
                        'default' => 'người đăng ký nhận ưu đãi',
                    ],
                ],
            ],
            [
                'key' => 'press',
                'label' => 'Báo chí & Nhật Bản',
                'icon' => 'globe',
                'description' => 'Phần giới thiệu sản phẩm được báo chí và người Nhật đánh giá.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề',
                        'type' => 'textarea',
                        'default' => 'Những ngày gần đây, trên một số tờ báo và kênh truyền hình nổi tiếng xuất hiện thông tin về sản phẩm Phân bón ROOTBIO giúp cây ra rễ mạnh, mầm khoẻ, sinh trưởng tốt.',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Sản phẩm cũng được người Nhật đánh giá cao, khi lấy nguồn nguyên liệu nhập khẩu chất lượng từ Nhật Bản.',
                    ],
                    [
                        'key' => 'badgeOne',
                        'label' => 'Huy hiệu 1',
                        'type' => 'text',
                        'default' => 'Được người Nhật đánh giá cao',
                    ],
                    [
                        'key' => 'badgeTwo',
                        'label' => 'Huy hiệu 2',
                        'type' => 'text',
                        'default' => 'Được chứng nhận bởi báo chí',
                    ],
                    [
                        'key' => 'image',
                        'label' => 'Ảnh minh hoạ',
                        'type' => 'image',
                        'default' => '/images/rootbio/japan.webp',
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
                        'default' => 'Bà con nông dân sau khi sử dụng phân bón ROOTBIO',
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
                                'quote' => 'Tôi đã dùng rất nhiều loại phân bón khác nhau, nhưng để tiết kiệm và hiệu quả nhanh nhất thì có lẽ là sản phẩm phân bón ROOTBIO này. hiệu quả rất nhanh mà lại tiết kiệm.',
                                'author' => 'Anh Hùng chủ trại Cà Phê Gia Lai',
                                'image' => '/images/rootbio/testimonial1.jpg',
                            ],
                            [
                                'quote' => 'Rất cảm ơn ROOTBIO đã cứu sống vườn cây của tôi, tôi không nghĩ nó hiệu quả nhanh đến vậy. lúc đầu thấy quảng cáo thì cũng mua thử dùng trước cho vài gốc. Ai ngờ hiệu quả nhanh thật sự, đúng là hàng nhật, chất thật.',
                                'author' => 'Anh Trần Hùng chủ trại bưởi ở Vĩnh Long',
                                'image' => '/images/rootbio/cta3.jpg',
                            ],
                            [
                                'quote' => 'Tôi cũng chỉ vô tình được bà con tặng cho 1 lọ dùng thử. Nhưng đúng là hiệu quả khách xa với nhưng loại phân bón trước kia từng sử dụng tôi mới đặt thêm 2 thùng về dùng cho toàn bộ vườn cây của mình. Bà con yên tâm mà dùng.',
                                'author' => 'Anh Việt Vương chủ trại ở Lâm Đồng',
                                'image' => '/images/rootbio/cta2.jpg',
                            ],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'highlights',
                'label' => 'Tác dụng nổi bật',
                'icon' => 'trophy',
                'description' => 'Danh sách các tác dụng nổi bật của sản phẩm.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề nhỏ',
                        'type' => 'text',
                        'default' => 'Tác dụng nổi bật của ROOTBIO',
                    ],
                    [
                        'key' => 'subheading',
                        'label' => 'Tiêu đề lớn',
                        'type' => 'text',
                        'default' => 'Cây xanh dày lá - vọt đọt - bung đọt chỉ sau 3 - 5 ngày',
                    ],
                    [
                        'key' => 'items',
                        'label' => 'Các tác dụng',
                        'type' => 'list',
                        'itemLabel' => 'Tác dụng',
                        'itemFields' => [
                            [
                                'key' => 'value',
                                'label' => 'Nội dung',
                                'type' => 'text',
                            ],
                        ],
                        'default' => [
                            ['value' => 'Siêu kích rễ, đi đọt cho cây sầu riêng, ca cao, cafe, điều, tiêu…'],
                            ['value' => 'Siêu kích mầm cho mọi loại cây, cây cảnh, cây bonsai, rau màu, cây ăn quả'],
                            ['value' => 'Mầm xanh ra đều mơn mởn khỏe mạnh, không chết thối, hoa trái phát triển mạnh'],
                            ['value' => 'Nguyên liệu nhập khẩu Nhật Bản, ứng dụng công nghệ sinh học của Nhật Bản'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'ingredients',
                'label' => 'Thành phần nguyên liệu',
                'icon' => 'beaker',
                'description' => 'Công nghệ và thành phần có trong sản phẩm.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Thành phần nguyên liệu và công nghệ',
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
                                'image' => '/images/rootbio/effect1.png',
                            ],
                            [
                                'title' => 'Công nghệ Nano',
                                'description' => 'Giúp các phân tử Nano Đạm, Nano Lân, Nano Kali giúp hấp thụ nhanh gấp 100 lần.',
                                'image' => '/images/rootbio/effect2.png',
                            ],
                            [
                                'title' => 'Amino acid',
                                'description' => 'Từ rong biển, bột cá, tảo biển, bột thịt giúp cung cấp hơn 50 loại amino acid.',
                                'image' => '/images/rootbio/effect3.png',
                            ],
                            [
                                'title' => 'Acid humic, Acid Fulvic',
                                'description' => 'Tinh chất bột khoáng... giúp hệ rễ của cây trồng phát triển cực kì mạnh mẽ.',
                                'image' => '/images/rootbio/effect4.png',
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
                'key' => 'cta',
                'label' => 'Form đăng ký',
                'icon' => 'clipboard-list',
                'description' => 'Nội dung quay cuốn và form đăng ký nhận ưu đãi.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Bà con đăng ký để được kỹ sư nông nghiệp tư vấn miễn phí',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Chọn tình trạng cây trồng để được chuyên gia tư vấn cải thiện ngay.',
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
                            ['value' => 'kích thích bung rễ cực mạnh'],
                            ['value' => 'nuôi hoa trái tốt, lá xanh mơn mởn'],
                            ['value' => 'KÍCH THÍCH BẬT CHỒI, BUNG ĐỌT'],
                            ['value' => 'TIẾT KIỆM CHI PHÍ, HIỆU QUẢ LÂU DÀI'],
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
                            ['value' => 'Tự hào là biểu tượng của sự đồng lòng và phục vụ, mang lại nguồn cung ứng phân bón chế phẩm sinh học hàng đầu.'],
                            ['value' => 'Sản phẩm được các cơ quan nhà nước kiểm nghiệm và chứng nhận, được kiểm soát chặt chẽ về chất lượng cũng giá thành hợp lý.'],
                            ['value' => 'Công ty đã nhận được nhiều bằng khen, chứng nhận để trở thành một trong những công ty tiên phong và có khả năng xuất sắc trong việc tạo ra những sản phẩm sinh học chất lượng.'],
                            ['value' => 'Được đưa ra thị trường Nhật Bản. Không chỉ đáp ứng được yêu cầu và kỳ vọng của khách hàng, mà còn vượt qua được các đối thủ cạnh tranh trong thị trường.'],
                        ],
                    ],
                    [
                        'key' => 'formTitle',
                        'label' => 'Tiêu đề form',
                        'type' => 'text',
                        'default' => 'Anh/Chị hãy điền thông tin để được chuyên gia tư vấn',
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
                        'default' => 'HT212',
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
                            ['value' => 'Cây ăn quả'],
                            ['value' => 'Cây cảnh'],
                            ['value' => 'Cây Bonsai'],
                            ['value' => 'Cây thân gỗ'],
                            ['value' => 'Cây rau, củ'],
                            ['value' => 'Cây hoa'],
                        ],
                    ],
                ],
            ],
            [
                'key' => 'certificates',
                'label' => 'Chứng nhận & Xét nghiệm',
                'icon' => 'shield-check',
                'description' => 'Ảnh chứng nhận và thông tin kiểm định sản phẩm.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề',
                        'type' => 'text',
                        'default' => 'Chứng nhận và xét nghiệm phân bón ROOTBIO',
                    ],
                    [
                        'key' => 'description',
                        'label' => 'Mô tả',
                        'type' => 'textarea',
                        'default' => 'Sản phẩm PHÂN BÓN ROOTBIO được Cục An toàn NÔNG NGHIỆP kiểm định an toàn và chất lượng, được bào chế theo công nghệ hiện đại và đạt chuẩn GMP.',
                    ],
                    [
                        'key' => 'image',
                        'label' => 'Ảnh chứng nhận',
                        'type' => 'image',
                        'default' => '/images/rootbio/certs.png',
                    ],
                    [
                        'key' => 'primaryCtaLabel',
                        'label' => 'Nút chính',
                        'type' => 'text',
                        'default' => 'Chỉ 2 lần phun – Đăng ký ngay',
                    ],
                    [
                        'key' => 'primaryCtaHref',
                        'label' => 'Liên kết nút chính',
                        'type' => 'text',
                        'default' => '#dang-ky',
                    ],
                    [
                        'key' => 'secondaryCtaLabel',
                        'label' => 'Nút phụ',
                        'type' => 'text',
                        'default' => 'Gọi 0973.42.6704',
                    ],
                    [
                        'key' => 'secondaryCtaHref',
                        'label' => 'Liên kết nút phụ',
                        'type' => 'text',
                        'default' => 'tel:0973426704',
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
                'key' => 'reviews',
                'label' => 'Đánh giá khách hàng',
                'icon' => 'star',
                'description' => 'Bảng điểm đánh giá và các bình luận chi tiết.',
                'fields' => [
                    [
                        'key' => 'heading',
                        'label' => 'Tiêu đề section',
                        'type' => 'text',
                        'default' => 'Khách hàng đánh giá về phân bón ROOTBIO',
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
                        'key' => 'ratingBars',
                        'label' => 'Biểu đồ điểm',
                        'type' => 'list',
                        'itemLabel' => 'Mức điểm',
                        'itemFields' => [
                            [
                                'key' => 'stars',
                                'label' => 'Số sao',
                                'type' => 'number',
                            ],
                            [
                                'key' => 'percent',
                                'label' => 'Tỉ lệ (%)',
                                'type' => 'number',
                            ],
                        ],
                        'default' => [
                            ['stars' => 5, 'percent' => 100],
                            ['stars' => 4, 'percent' => 0],
                            ['stars' => 3, 'percent' => 0],
                            ['stars' => 2, 'percent' => 0],
                            ['stars' => 1, 'percent' => 0],
                        ],
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
                                'content' => 'Thích cái là hàng trực tiếp từ nhà máy nên cũng yên tâm, với cả giá cũng hợp lý. Xài mấy ngày là thấy rể với đọt ra rồi, nhanh thiệt.',
                            ],
                            [
                                'name' => 'Kim Hậu',
                                'time' => '1 giờ trước',
                                'content' => 'Nhà mình có vườn sầu, mà thấy bác hàng xóm quảng cáo quá trời, mua 1 thùng về dùng thử, hiệu quả lắm, mà mua theo thùng thì được chiết khấu ưu đãi nhiều nữa.',
                            ],
                            [
                                'name' => 'Kim Lan',
                                'time' => '1 tiếng trước',
                                'content' => 'Vườn tui có mấy cây ăn trái năm đầu xong bị chết đọt, vàng lá mình sử dụng loại này thấy ok lắm.',
                            ],
                            [
                                'name' => 'Uyên Trần',
                                'time' => '2 tiếng trước',
                                'content' => 'Cái này mua theo vườn bên cạnh tại thấy cây tốt mà ra hoa cũng đậu quả nhiều. Cũng may nó mới cứ được cái rẫy nhà mình.',
                            ],
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
                        'default' => 'Sử dụng phân bón ROOTBIO sẽ giúp cây trồng của bạn chắc khoẻ từ sâu bên trong, phát triển một cách mạnh mẽ, đem đến năng suất vượt trội',
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
                        'default' => 'HT212',
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
                        'default' => 'Đăng ký ngay',
                    ],
                    [
                        'key' => 'buttonHref',
                        'label' => 'Liên kết nút bấm',
                        'type' => 'text',
                        'default' => '#dang-ky',
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
                        'default' => 'ROOTBIO',
                    ],
                    [
                        'key' => 'companyName',
                        'label' => 'Tên công ty',
                        'type' => 'text',
                        'default' => 'CÔNG TY TNHH WI GROUP',
                    ],
                    [
                        'key' => 'address',
                        'label' => 'Địa chỉ',
                        'type' => 'textarea',
                        'default' => 'ĐỊA CHỈ: Tầng 4 Toà TH OFFICE TOWER 18, Số 438 Đường Khương Đình, Phường Hạ Đình, Thanh Xuân, Hà Nội',
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
                        'default' => 'Copyright @ ROOTBIO - Tập Đoàn Phân Bón Sinh Học. All Rights Reserved',
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
                        'label' => 'Nút đăng ký',
                        'type' => 'text',
                        'default' => 'Đăng ký nhận ưu đãi',
                    ],
                    [
                        'key' => 'registerHref',
                        'label' => 'Liên kết đăng ký',
                        'type' => 'text',
                        'default' => '#dang-ky',
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
            static fn (array $item): string => (string) ($item['value'] ?? ''),
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
            static fn (array $item): string => (string) ($item['value'] ?? ''),
            static::get()['cta']['plantTypes'] ?? [],
        )));
    }
}
