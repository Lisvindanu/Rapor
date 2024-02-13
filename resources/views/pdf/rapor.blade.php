@extends('pdf.template-pdf')

@section('content')
    <div class="container">
        <div class="header-judul">
            {{-- <h1 style="margin-top: 40px">{{ $title }}</h1> --}}
            <h1 style="margin-top: 40px">Rapor Kinerja Individu</h1>
            {{-- <h3>{{ $subtitle }}</h3> --}}
            <h4>SEMESTER GANJIL 2021/2022</h4>
        </div>
    
    <table>
        <tr>
            <td>NIDN</td>
            <td>:</td>
            <td>0404096902</td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>:</td>
            <td>Dr.Ir. Evi Afiatun, M.T.</td>
        </tr>
        <tr>
            <td>PRODI</td>
            <td>:</td>
            <td>Teknik Lingkungan</td>
        </tr>
    </table>

    <table class="table-rapor">
        <th colspan="2">Indikator Kinerja</th>
        <th>Target</th>
        <th>Fakta</th>
        <th>Nilai</th>
        <th>Bobot(%)</th>
        <th>Nilai Per Indikator</th>

        <tr>
            <td colspan="5">a. Unsur BKD Sister</td>
            {{-- {{-- <td rowspan="6">50</td> --}}
            <td class="kolom-tengah" rowspan="6">50</td>
            <td class="kolom-tengah" rowspan="6">50</td>
        </tr>
        <tr>
            <td class="kolom-nomor">1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>

        <tr>
            <td colspan="5">a. Unsur BKD Sister</td>
            {{-- {{-- <td rowspan="6">50</td> --}}
            <td rowspan="5" class="kolom-tengah">50</td>
            <td rowspan="5" class="kolom-tengah">50</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>

        <tr>
            <td colspan="5">a. Unsur BKD Sister</td>
            {{-- {{-- <td rowspan="6">50</td> --}}
            <td rowspan="3" class="kolom-tengah">50</td>
            <td rowspan="3" class="kolom-tengah">50</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td>1.</td>
            <td>Pendidikan</td>
            <td>M</td>
            <td>M</td>
            <td>100</td>
        </tr>
        <tr>
            <td colspan="2" style="border: 0px solid #dddddd"></td>
            <td colspan="3">TOTAL NILAI</td>
            <td colspan="2">100</td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td colspan="3">GRADE</td>
            <td colspan="2">Baik</td>
        </tr>
    </table>
</div>
   
    {{-- <h1>Halaman 1</h1>
    <p>Ini adalah konten halaman 1.</p>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut rem eaque deleniti corporis! Obcaecati, laborum neque laboriosam doloribus sint asperiores sunt, maxime aut iste numquam animi quas eius aspernatur aperiam. Dolore est possimus atque nulla, error asperiores tempora! Deleniti consequatur officiis mollitia eos placeat quo autem porro vel necessitatibus, dolorem quas cupiditate quos optio dolor pariatur temporibus laborum eveniet? In voluptas molestias recusandae suscipit repellendus tempora voluptatem, maxime obcaecati dignissimos velit ipsam quas laborum modi necessitatibus vitae alias repellat impedit explicabo eum ad dicta quos? In quibusdam distinctio, labore officia nesciunt, quo quaerat alias rerum doloremque voluptate natus impedit nostrum asperiores dicta non aperiam quasi aut. Cum atque debitis id dolorum laboriosam at praesentium molestiae, distinctio est doloremque sapiente saepe iusto! Adipisci cupiditate fugit eligendi beatae, atque, quibusdam laudantium quo maiores quod minus, dolores temporibus voluptatem suscipit ducimus blanditiis. Pariatur deleniti unde voluptatum perspiciatis ut adipisci, quis accusamus excepturi libero repellendus dolores saepe sint eaque, repellat quas magnam asperiores nostrum labore voluptates maxime eos, iste voluptatibus. Quam doloribus laboriosam veniam repudiandae officiis omnis odit ratione? Eius ab animi doloribus assumenda hic. Maiores cumque debitis provident obcaecati. Beatae, eius inventore soluta suscipit, fuga nostrum sint neque explicabo, quam magni repellendus laboriosam earum assumenda. Saepe nam nisi consequuntur modi aliquid doloribus commodi nemo possimus quod labore expedita fugiat tenetur eius repellendus, atque deleniti aperiam nobis. Rem similique quas enim illum accusantium? Alias quos sequi sed in. Dolores, assumenda perspiciatis, quisquam similique quaerat impedit, earum culpa harum fuga porro ullam non laboriosam architecto delectus fugiat doloribus quam recusandae sapiente mollitia sed maiores. Tenetur ullam rem ut voluptatum recusandae ipsam, commodi harum iusto sint blanditiis soluta nostrum hic consectetur vitae. Quisquam ratione et reiciendis doloribus recusandae atque voluptatum earum. Eligendi, iste reprehenderit? Sed iure quod tempora illum! Explicabo sequi beatae nam quam molestias adipisci blanditiis voluptatem, fugit eaque repellat tenetur cum vero ut iusto debitis rerum harum! Quam nulla necessitatibus, ipsum, cum magni accusamus minima unde ex eum provident tenetur saepe! Temporibus quis laboriosam adipisci praesentium nisi quam, natus iusto maxime expedita non possimus voluptas ab omnis hic illo velit magni tempore, perspiciatis fugiat nobis optio quisquam dolore saepe. Reprehenderit corrupti quod consequuntur hic. Cupiditate voluptatem, quis numquam alias vero recusandae? Natus officia est id odit necessitatibus quaerat ex sunt quasi adipisci assumenda similique sit dolor facere, quo perferendis at suscipit corporis, dolorem recusandae eaque consequuntur maxime vero magni. Praesentium quibusdam quis, unde sapiente omnis, reprehenderit enim soluta voluptatem impedit quaerat ullam quod! Sed vitae accusamus, fugit hic molestiae veniam modi odio? Accusamus, quae. Porro ipsam minima cumque corrupti, fugit minus veritatis delectus ea corporis necessitatibus consequuntur quis expedita quasi eligendi nemo rerum, tempore iste possimus explicabo cupiditate at asperiores? Similique quod molestias, asperiores error neque in sed nisi cupiditate quia ipsa, pariatur minus consequatur iusto labore excepturi voluptatum nemo est consequuntur tempora iure quaerat fuga. Eum dolores corrupti, atque quibusdam ipsa a, necessitatibus perspiciatis, suscipit ea nesciunt consectetur explicabo vero itaque? Voluptatem quo temporibus incidunt. Aut porro eius rerum nulla ex at pariatur.</p> --}}
    <!-- Tambahkan konten halaman selanjutnya di sini -->
    {{-- <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Rem, aut quis facilis optio explicabo amet provident? Commodi incidunt eum assumenda nihil excepturi tempore iure magni adipisci fuga exercitationem voluptate neque tenetur aliquam, quisquam ex deserunt iste obcaecati qui sit aliquid architecto expedita odio perspiciatis? Asperiores non suscipit quod laboriosam nobis. Harum est placeat facilis, nulla reprehenderit inventore sequi neque at dolores temporibus. Doloribus libero iure voluptate odio dolorum tempore ex voluptas harum, soluta veniam aut fugit id nobis deserunt? Dolorum nostrum necessitatibus vero ipsa rerum sint sunt cum! Asperiores laudantium vitae placeat ipsam! Nemo facilis impedit tenetur labore ut laudantium. Enim vero id itaque iure! Perferendis corrupti fugiat veniam veritatis, aliquid, rerum explicabo eveniet deleniti nesciunt aperiam ab, hic consectetur doloribus quia culpa mollitia exercitationem dolorum? Iusto autem, ipsum aspernatur odit dolore sapiente iste similique iure accusamus laboriosam ab corrupti delectus minus aut! Ad beatae maiores perferendis et est quas? Praesentium reiciendis doloribus repellendus alias, minus non voluptates beatae velit, assumenda nam nulla cupiditate tempora repellat sed, mollitia dicta quam sit accusantium culpa fuga quo temporibus odit. Possimus nulla harum dolorum accusamus! Maiores, officia? Illo minus ipsam quod reprehenderit quos vel rerum assumenda expedita! Quod architecto odio assumenda impedit voluptas nobis a maiores aliquam pariatur adipisci eius animi vitae cupiditate possimus soluta, mollitia maxime qui earum amet eaque nulla. Aliquid quasi asperiores eveniet, ut corrupti assumenda commodi cum doloremque debitis! Nulla, officiis! Laudantium, deserunt alias et incidunt omnis fuga cupiditate culpa praesentium est sint iure suscipit nam cumque esse nobis, necessitatibus numquam beatae? Rerum unde aspernatur sunt. Laboriosam veritatis maxime, fugiat beatae illo ex vero distinctio sed, aliquam dolores ullam quidem? Temporibus architecto distinctio, reiciendis id provident obcaecati voluptatum ea odio eos recusandae explicabo. Nemo quas rem illo saepe minima! Beatae dicta cum, soluta debitis tempora totam dolores facilis repellat voluptatibus laboriosam ullam nihil eius quia consectetur, cupiditate placeat repellendus nemo consequatur itaque sit ab voluptatem optio? Minima maiores sapiente culpa repellat debitis doloribus reprehenderit alias quidem tempora? Fuga fugiat dolorem, quod ratione perferendis, nesciunt veniam nostrum veritatis aliquid culpa laudantium molestiae voluptatem molestias quos facere quae, vero aut. Molestiae odit ea cum hic a necessitatibus beatae libero vero quae! Eligendi exercitationem corporis, aliquid illo ut repellat explicabo nesciunt blanditiis aliquam architecto. Libero saepe distinctio sit, vero harum voluptatibus consequatur fuga. Quidem obcaecati enim magnam modi debitis aspernatur ab dolorum, adipisci eligendi corrupti distinctio animi necessitatibus molestias doloribus praesentium omnis eveniet recusandae ad nemo sequi dolores, rem nesciunt iusto laborum. Voluptatibus nulla unde, similique excepturi quae magnam, eum rerum laborum itaque dolorem modi ipsam eius officiis aliquam, ea impedit quam officia hic ut architecto animi sunt. Dolore quos eum animi, perferendis delectus accusamus tenetur nulla numquam error porro officia? Consequatur sit maxime quos, officia nulla excepturi, saepe, dolorum quod molestiae animi deserunt molestias. Voluptatem nulla libero quo. Magnam unde error ratione iusto, recusandae ipsum quos eaque molestias minima commodi. Quo facere corporis dolores molestiae, nostrum commodi! Vel placeat repellat fugit quaerat, delectus iusto soluta enim quidem, consectetur suscipit fuga illo pariatur voluptatibus atque? Illo laboriosam quas ipsam ut mollitia, pariatur minus accusantium neque nihil perferendis cum consequatur sequi, exercitationem eum aspernatur soluta consectetur error deleniti suscipit iure blanditiis magni! Libero perspiciatis debitis sit eaque, in reiciendis dolorum nulla quis nobis fuga vero atque ipsum vitae dicta ea possimus, optio molestias quo. Similique mollitia quia non molestias! Est et nostrum tempora cum, corporis itaque repellat incidunt delectus voluptatibus quaerat omnis minus. Laborum hic autem rem deserunt repellat voluptates ratione perferendis, enim, minima quaerat illo omnis adipisci illum necessitatibus, tenetur voluptas accusamus eligendi? Quis quaerat velit incidunt beatae, consectetur reprehenderit libero aliquid maiores, quasi quisquam corporis dolorem asperiores. Voluptate cupiditate at magni eveniet suscipit, saepe delectus dolorem rem blanditiis a quidem laborum accusamus enim? Fuga iste necessitatibus esse, laborum ipsum architecto, suscipit temporibus quae culpa voluptatibus id rerum mollitia aliquid vitae perspiciatis nisi voluptatum ratione deserunt? Voluptas nulla delectus, ipsum eos deleniti ipsa? Mollitia esse tempora dolor nostrum labore quisquam alias commodi quaerat doloribus sapiente eum, non fugiat voluptates praesentium neque facilis reprehenderit! Accusantium impedit natus at saepe in itaque assumenda? Incidunt, porro officiis. Aliquid sed voluptatum eaque pariatur temporibus delectus beatae nostrum, veritatis consectetur blanditiis magnam nemo mollitia repudiandae ut dolores illum ratione, rem tenetur minima cumque eum? Vitae ea doloribus necessitatibus laboriosam labore cupiditate, consequuntur repellat corporis officia quibusdam numquam hic quas eum. Veritatis voluptatum quia, facilis earum optio expedita dignissimos ullam, corporis vitae nesciunt perferendis officiis nulla temporibus doloremque eveniet incidunt iusto sequi? Optio autem velit quod temporibus dolorum sunt at perferendis, aliquid omnis. Officiis harum ab sequi delectus voluptates non suscipit nulla, dolores temporibus quos quidem sint iusto adipisci animi magni natus consequatur eos possimus, porro omnis ut veritatis qui! Sequi, necessitatibus provident hic iure officiis cupiditate cumque. Recusandae reiciendis ad ducimus praesentium odit veniam error, quia adipisci reprehenderit consectetur doloribus aperiam saepe id corporis dolor fuga totam enim tempora sint voluptate earum laborum perferendis. Repellat animi, ducimus, aliquid amet, officia quia nihil laudantium quam accusantium minima earum? Ab delectus in voluptatem est earum dolorem corporis aperiam quia vel, iste reiciendis inventore esse debitis necessitatibus recusandae quisquam odit quas vero, modi tempora dicta tenetur. Incidunt ullam nam, ipsam fugit fuga accusantium at qui adipisci recusandae, id unde deleniti nobis libero suscipit esse porro commodi pariatur est maiores aut culpa beatae? Animi, eveniet magni. Corrupti tempore consequatur quod cumque hic, illum minus eaque molestias, laborum sunt numquam, labore totam ratione omnis dicta id velit. Eos laudantium numquam error possimus earum illum, tenetur eveniet placeat labore veniam ipsa! Mollitia, fuga iusto commodi harum, veniam non reiciendis delectus adipisci dolore accusantium quaerat molestias aspernatur enim blanditiis rem iure rerum quasi corporis consequuntur explicabo nobis! Dolores architecto fugit eum eveniet dolore laudantium. Provident quo cupiditate eligendi eius mollitia perspiciatis et incidunt, velit quaerat. Repellat, mollitia dolores. Debitis error autem, voluptate obcaecati, beatae officia doloribus dolor magni similique adipisci consectetur modi eveniet voluptas qui blanditiis incidunt nihil ratione! Nulla, ab vel! Repudiandae excepturi dicta saepe totam quisquam explicabo accusamus. Odio molestias velit voluptatum?</p> --}}
@endsection
