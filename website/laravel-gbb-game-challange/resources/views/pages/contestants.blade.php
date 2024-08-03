@extends('layout')
@section('content')
    <div class="main-content">
        <div class="container">
            <div style="text-align:center;margin-top:20px;">
                <h2>
                    <span id="contestants-count" class="cl-g">0</span>
                    <span id="contestants-status" class="cl-g">Katılımcı</span>
                </h2>
                <div>
                    <h5>
                        <a href="/admin/contestantsfiles">Dosyalar</a>
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <nav class="navbar navbar-light justify-content-end filter-con">
                        <div id="filter-1">
                        <select name="" id="filter-box">
                            <option value="Filtre" selected disabled>Filtre</option>
                            <option value="Hepsi">Hepsi</option>
                            <option value="Kazandı">Kazananlar</option>
                            <option value="Kaybetti">Kaybedenler</option>
                            <option value="Geçersiz">Geçersizler</option>
                            <option value="Bekliyor">Bekleyenler</option>
                            <option value="">-----------</option>
                            <option value="1.">Birinciler</option>
                            <option value="2.">İkinciler</option>
                            <option value="3.">Üçüncüler</option>
                        </select>
                        </div>
                    </nav>
                    <table class="table">
                        <thead>
                            <tr class="contestants-column-left">
                                <th scope="col">Ad</th>
                                <th scope="col">Soyad</th>
                                <th scope="col">TC</th>
                                <th scope="col">Durum</th>
                                <th scope="col-lg-4">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody id="contestants-list">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        let contestants = []
        let filterBox = 'Hepsi'
        let list = document.getElementById('contestants-list')
        const getcontestantsList = async () => {
            const result = await fetch('/getcontestants')
            const final = await result.json()
            contestants.push(final.contestants)
            getConstents(final.contestants)
        }
        getcontestantsList()

        const getConstents = (param) => {
            list.innerHTML = ''
            for (const item of param) {
                list.innerHTML +=  `
                    <tr class="${item.status} cts-list">
                        <td>${item.name}</td>
                        <td>${item.lastname}</td>
                        <td>${item.identity}</td>
                        <td>${item.status}</td>
                        <td class="col-lg-1">
                            <div class="btn btn-primary">
                                <a  href="details/${item.id}" style="color:#fff;">Detaylar</a>
                            </div>
                        </td>
                        <td class="col-lg-1">
                            <div class="btn btn-danger" onclick="deleteContestant(${item.id}, event)">
                                <a style="color:#fff;">Sil</a>
                            </div>
                        </td>
                    </tr>
                `
            }
            document.getElementById('contestants-count').innerText = param.length
        }

        document.getElementById('filter-box').addEventListener('change', (e) => {
            filterBox = e.target.value
            document.getElementById('contestants-status').innerText = filterBox
            if(filterBox === 'Hepsi'){
                getConstents(contestants[0])
            } else{
                if(filterBox === '1.' || filterBox === '2.' || filterBox === '3.'){
                    const filterContestants = contestants[0].filter(item => item.line === filterBox)
                    getConstents(filterContestants)
                } else{
                    const filterContestants = contestants[0].filter(item => item.status === filterBox)
                    getConstents(filterContestants)
                }
            }
        })
        const deleteContestant = async(id,event) => {
            const result = await fetch('/deletecontestant',{
                headers: {
                    Accept: 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':'{{csrf_token()}}',
                },
                method:'POST',
                body:JSON.stringify({
                    id: id
                })
            })
            if(result.status === 200){
                event.target.parentNode.parentNode.parentNode.remove()
            }
        }
    </script>
@stop
