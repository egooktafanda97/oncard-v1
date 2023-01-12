<?php
// php artisan db:seed --class=Database\Seeders\Guru\Guru
namespace Database\Seeders\Guru;

use App\Models\Instansi;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Traits\ManagementRoler;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Service\Control\ManagementCrud;

class Guru extends Seeder
{
    use ManagementRoler;
    private $data =  [
        "Academic librarian",
        "Accountant",
        "Accounting technician",
        "Actuary",
        "Adult nurse",
        "Advertising account executive",
        "Advertising account planner",
        "Advertising copywriter",
        "Advice worker",
        "Advocate (Scotland)",
        "Aeronautical engineer",
        "Agricultural consultant",
        "Agricultural manager",
        "Aid worker/humanitarian worker",
        "Air traffic controller",
        "Airline cabin crew",
        "Amenity horticulturist",
        "Analytical chemist",
        "Animal nutritionist",
        "Animator",
        "Archaeologist",
        "Architect",
        "Architectural technologist",
        "Archivist",
        "Armed forces officer",
        "Aromatherapist",
        "Art therapist",
        "Arts administrator",
        "Auditor",
        "Automotive engineer",
        "Barrister",
        "Barrister s clerk",
        "Bilingual secretary",
        "Biomedical engineer",
        "Biomedical scientist",
        "Biotechnologist",
        "Brand manager",
        "Broadcasting presenter",
        "Building control officer/surveyor",
        "Building services engineer",
        "Building surveyor",
        "Camera operator",
        "Careers adviser (higher education)",
        "Careers adviser",
        "Careers consultant",
        "Cartographer",
        "Catering manager",
        "Charities administrator",
        "Charities fundraiser",
        "Chemical (process) engineer",
        "Child psychotherapist",
        "Children's nurse",
        "Chiropractor",
        "Civil engineer",
        "Civil Service administrator",
        "Clinical biochemist",
        "Clinical cytogeneticist",
        "Clinical microbiologist",
        "Clinical molecular geneticist",
        "Clinical research associate",
        "Clinical scientist - tissue typing",
        "Clothing and textile technologist",
        "Colour technologist",
        "Commercial horticulturist",
        "Commercial/residential/rural surveyor",
        "Commissioning editor",
        "Commissioning engineer",
        "Commodity broker",
        "Communications engineer",
        "Community arts worker",
        "Community education officer",
        "Community worker",
        "Company secretary",
        "Computer sales support",
        "Computer scientist",
        "Conference organiser",
        "Consultant",
        "Consumer rights adviser",
        "Control and instrumentation engineer",
        "Corporate banker",
        "Corporate treasurer",
        "Counsellor",
        "Courier/tour guide",
        "Court reporter/verbatim reporter",
        "Credit analyst",
        "Crown Prosecution Service lawyer",
        "Crystallographer",
        "Curator",
        "Customs officer",
        "Cyber security specialist",
        "Dance movement therapist",
        "Data analyst",
        "Data scientist",
        "Data visualisation analyst",
        "Database administrator",
        "Debt/finance adviser",
        "Dental hygienist",
        "Dentist",
        "Design engineer",
        "Dietitian",
        "Diplomatic service",
        "Doctor (general practitioner, GP)",
        "Doctor (hospital)",
        "Dramatherapist",
        "Economist",
        "Editorial assistant",
        "Education administrator",
        "Electrical engineer",
        "Electronics engineer",
        "Employment advice worker",
        "Energy conservation officer",
        "Engineering geologist",
        "Environmental education officer",
        "Environmental health officer",
        "Environmental manager",
        "Environmental scientist",
        "Equal opportunities officer",
        "Equality and diversity officer",
        "Ergonomist",
        "Estate agent",
        "European Commission administrators",
        "Exhibition display designer",
        "Exhibition organiser",
        "Exploration geologist",
        "Facilities manager",
        "Field trials officer",
        "Financial manager",
        "Firefighter",
        "Fisheries officer",
        "Fitness centre manager",
        "Food scientist",
        "Food technologist",
        "Forensic scientist",
        "Geneticist",
        "Geographical information systems manager",
        "Geomatics/land surveyor",
        "Government lawyer",
        "Government research officer",
        "Graphic designer",
        "Health and safety adviser",
        "Health and safety inspector",
        "Health promotion specialist",
        "Health service manager",
        "Health visitor",
        "Herbalist",
        "Heritage manager",
        "Higher education administrator",
        "Higher education advice worker",
        "Homeless worker",
        "Horticultural consultant",
        "Hotel manager",
        "Housing adviser",
        "Human resources officer",
        "Hydrologist",
        "Illustrator",
        "Immigration officer",
        "Immunologist",
        "Industrial/product designer",
        "Information scientist",
        "Information systems manager",
        "Information technology/software trainers",
        "Insurance broker",
        "Insurance claims inspector",
        "Insurance risk surveyor",
        "Insurance underwriter",
        "Interpreter",
        "Investment analyst",
        "Investment banker - corporate finance",
        "Investment banker - operations",
        "Investment fund manager",
        "IT consultant",
        "IT support analyst",
        "Journalist",
        "Laboratory technician",
        "Land-based engineer",
        "Landscape architect",
        "Learning disability nurse",
        "Learning mentor",
        "Lecturer (adult education)",
        "Lecturer (further education)",
        "Lecturer (higher education)",
        "Legal executive",
        "Leisure centre manager",
        "Licensed conveyancer",
        "Local government administrator",
        "Local government lawyer",
        "Logistics/distribution manager",
        "Magazine features editor",
        "Magazine journalist",
        "Maintenance engineer",
        "Management accountant",
        "Manufacturing engineer",
        "Manufacturing machine operator",
        "Manufacturing toolmaker",
        "Marine scientist",
        "Market research analyst",
        "Market research executive",
        "Marketing account manager",
        "Marketing assistant",
        "Marketing executive",
        "Marketing manager (social media)",
        "Materials engineer",
        "Materials specialist",
        "Mechanical engineer",
        "Media analyst",
        "Media buyer",
        "Media planner",
        "Medical physicist",
        "Medical representative",
        "Mental health nurse",
        "Metallurgist",
        "Meteorologist",
        "Microbiologist",
        "Midwife",
        "Mining engineer",
        "Mobile developer",
        "Multimedia programmer",
        "Multimedia specialists",
        "Museum education officer",
        "Museum/gallery exhibition officer",
        "Music therapist",
        "Nanoscientist",
        "Nature conservation officer",
        "Naval architect",
        "Network administrator",
        "Nurse",
        "Nutritional therapist",
        "Nutritionist",
        "Occupational therapist",
        "Oceanographer",
        "Office manager",
        "Operational researcher",
        "Orthoptist",
        "Outdoor pursuits manager",
        "Packaging technologist",
        "Paediatric nurse",
        "Paramedic",
        "Patent attorney",
        "Patent examiner",
        "Pension scheme manager",
        "Personal assistant",
        "Petroleum engineer",
        "Pharmacist",
        "Pharmacologist",
        "Pharmacovigilance officer",
        "Photographer",
        "Physiotherapist",
        "Picture researcher",
        "Planning and development surveyor",
        "Planning technician",
        "Plant breeder",
        "Police officer",
        "Political party agent",
        "Political party research officer",
        "Practice nurse",
        "Press photographer",
        "Press sub-editor",
        "Prison officer",
        "Private music teacher",
        "Probation officer",
        "Product development scientist",
        "Production manager",
        "Programme researcher",
        "Project manager",
        "Psychologist (clinical)",
        "Psychologist (educational)",
        "Psychotherapist",
        "Public affairs consultant (lobbyist)",
        "Public affairs consultant (research)",
        "Public house manager",
        "Public librarian",
        "Public relations (PR) officer",
        "QA analyst",
        "Quality assurance manager",
        "Quantity surveyor",
        "Records manager",
        "Recruitment consultant",
        "Recycling officer",
        "Regulatory affairs officer",
        "Research chemist",
        "Research scientist",
        "Restaurant manager",
        "Retail banker",
        "Retail buyer",
        "Retail manager",
        "Retail merchandiser",
        "Retail pharmacist",
        "Sales executive",
        "Sales manager",
        "Scene of crime officer",
        "Secretary",
        "Seismic interpreter",
        "Site engineer",
        "Site manager",
        "Social researcher",
        "Social worker",
        "Software developer",
        "Soil scientist",
        "Solicitor",
        "Speech and language therapist",
        "Sports coach",
        "Sports development officer",
        "Sports therapist",
        "Statistician",
        "Stockbroker",
        "Structural engineer",
        "Systems analyst",
        "Systems developer",
        "Tax inspector",
        "Teacher (nursery/early years)",
        "Teacher (primary)",
        "Teacher (secondary)",
        "Teacher (special educational needs)",
        "Teaching/classroom assistant",
        "Technical author",
        "Technical sales engineer",
        "TEFL/TESL teacher",
        "Television production assistant",
        "Test automation developer",
        "Tour operator",
        "Tourism officer",
        "Tourist information manager",
        "Town and country planner",
        "Toxicologist",
        "Trade union research officer",
        "Trader",
        "Trading standards officer",
        "Training and development officer",
        "Translator",
        "Transportation planner",
        "Travel agent",
        "TV/film/theatre set designer",
        "UX designer",
        "Validation engineer",
        "Veterinary nurse",
        "Veterinary surgeon",
        "Video game designer",
        "Video game developer",
        "Volunteer work organiser",
        "Warehouse manager",
        "Waste disposal officer",
        "Water conservation officer",
        "Water engineer",
        "Web designer",
        "Web developer",
        "Welfare rights adviser",
        "Writer",
        "Youth worker"
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $instansi = Instansi::all();
        foreach ($instansi as $key => $value) {
            $this->create_jabatan_fungsional($value);
            $this->create_jabatan_struktural($value);
            $this->create_jabatan_khusus($value);
            $this->create_unit_konsentrasi($value);

            for ($i = 0; $i < 10; $i++) {
                $request = new \Illuminate\Http\Request();
                $events = $faker->dateTimeBetween('-30 days', '+30 days');
                $_jf = \App\Models\JabatanFungsional::whereInstansiId($value->id)->get();
                $__id_jf = "";
                foreach ($_jf as $x => $xx) {
                    if (rand(0, 1) == 1)
                        $__id_jf = $xx->id;
                    else
                        continue;
                }

                $_js = \App\Models\JabatanStruktural::whereInstansiId($value->id)->get();
                $__id_js = "";
                foreach ($_js as $x => $xx) {
                    if (rand(0, 1) == 1)
                        $__id_js = $xx->id;
                    else
                        continue;
                }

                $_jk = \App\Models\JabatanKhusus::whereInstansiId($value->id)->get();
                $__id_jk = "";
                foreach ($_jk as $x => $xx) {
                    if (rand(0, 1) == 1)
                        $__id_jk = $xx->id;
                    else
                        continue;
                }

                $_uk = \App\Models\UnitKonsentrasi::whereInstansiId($value->id)->get();
                $__id_uk = "";
                foreach ($_uk as $x => $xx) {
                    if (rand(0, 1) == 1)
                        $__id_uk = $xx->id;
                    else
                        continue;
                }
                $data_guru = [
                    "kode_instansi" => $value->kode_instansi,
                    "instansi_id" => $value->id,
                    "nama_lengkap" => $faker->name,
                    "no_telepon" => $faker->phoneNumber(),
                    "jenis_kelamin" => $faker->randomElement(['LAKI-LAKI', 'PEREMPUAN']),
                    "tempat_lahir" =>  $faker->address,
                    "tanggal_lahir" => $events->format('Y-m-d'),
                    "agama" => "Islam",
                    "alamat_lengkap" => $faker->address,
                    "provinsi" => "Riau",
                    "kabupaten" => "Kuantan Singingi",
                    "kecamatan" => "Kuantan Tengah",
                    "kelurahan" => "desa dummy",
                    "jabatan_fungsional_id" => $__id_jf,
                    "jabatan_struktural_id" => $__id_js,
                    "jabatan_khusus_id" =>  $__id_jk,
                    "unit_konsentrasi_id" => $__id_uk,
                    "pns" => rand(0, 1),
                    "mengajar" => rand(0, 1),
                    'username'    => $faker->userName,
                    'email' => $faker->unique()->safeEmail(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    "pin" => "1234",
                    "code_reference" => Str::random(40),
                    "role" => "guru",
                ];
                // dd($data_guru);
                $m_guru = new ManagementCrud("Guru");
                $pathJson =  config('generator_crud_config.scema_path');
                $m_guru->instance($pathJson);
                $m_guru->setNameSpaceModel("\App\Models\\");
                $m_guru->setTesting();


                $result = $request->replace($data_guru);
                $z_data = $m_guru->generate_data_insert($result);
                if (empty($z_data['data']))
                    dd($z_data);
                if (!$roler = $this->newRole("api", "guru"))
                    return false;
                $_siswa = User::find($z_data['data']['user_id']);
                $this->createRole($_siswa, $roler);
            }
        }
    }
    public function create_jabatan_fungsional($instansi)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $jbtn = new ManagementCrud("JabatanFungsional");
            $pathJson =  config('generator_crud_config.scema_path');
            $jbtn->instance($pathJson);
            $jbtn->setNameSpaceModel("\App\Models\\");
            $jbtn->setTesting();

            $request = new \Illuminate\Http\Request();
            $index_data = rand(0, count($this->data));
            $jbt = $request->replace([
                "kode_instansi"     => $instansi->kode_instansi,
                "instansi_id"   => $instansi->id,
                "parent_hierarchy"  => rand(1, 3),
                "nama_jabatan"  => $this->data[$index_data],
                "keterangan"    => $faker->realText(80)
            ]);
            $or = $jbtn->generate_data_insert($jbt);
            if (empty($or['data']))
                dd($or);
        }
    }
    public function create_jabatan_struktural($instansi)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $jbtn = new ManagementCrud("JabatanStruktural");
            $pathJson =  config('generator_crud_config.scema_path');
            $jbtn->instance($pathJson);
            $jbtn->setNameSpaceModel("\App\Models\\");
            $jbtn->setTesting();
            $request = new \Illuminate\Http\Request();
            $index_data = rand(0, count($this->data));
            $jbt = $request->replace([
                "kode_instansi"     => $instansi->kode_instansi,
                "instansi_id"   => $instansi->id,
                "parent_hierarchy"  => rand(1, 3),
                "nama_jabatan"  => $this->data[$index_data],
                "keterangan"    => $faker->realText(80)
            ]);
            $or = $jbtn->generate_data_insert($jbt);
            if (empty($or['data']))
                dd($or);
        }
    }
    public function create_jabatan_khusus($instansi)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $jbtn = new ManagementCrud("JabatanKhusus");
            $pathJson =  config('generator_crud_config.scema_path');
            $jbtn->instance($pathJson);
            $jbtn->setNameSpaceModel("\App\Models\\");
            $jbtn->setTesting();
            $request = new \Illuminate\Http\Request();
            $index_data = rand(0, count($this->data));
            $jbt = $request->replace([
                "kode_instansi"     => $instansi->kode_instansi,
                "instansi_id"   => $instansi->id,
                "parent_hierarchy"  => rand(1, 3),
                "nama_jabatan"  => $this->data[$index_data],
                "keterangan"    => $faker->realText(80)
            ]);
            $or = $jbtn->generate_data_insert($jbt);
            if (empty($or['data']))
                dd($or);
        }
    }
    public function create_unit_konsentrasi($instansi)
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            $jbtn = new ManagementCrud("UnitKonsentrasi");
            $pathJson =  config('generator_crud_config.scema_path');
            $jbtn->instance($pathJson);
            $jbtn->setNameSpaceModel("\App\Models\\");
            $jbtn->setTesting();
            $request = new \Illuminate\Http\Request();
            $index_data = rand(0, (count($this->data) - 1));
            $jbt = $request->replace([
                "kode_instansi"     => $instansi->kode_instansi,
                "instansi_id"   => $instansi->id,
                "nama_unit"  => $this->data[$index_data],
                "keterangan"    => $faker->realText(80)
            ]);
            $or = $jbtn->generate_data_insert($jbt);
            if (empty($or['data']))
                dd($or);
        }
    }
}
