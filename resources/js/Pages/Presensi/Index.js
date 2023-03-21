import React from 'react'
import Authenticated from '@/Layouts/Authenticated'
import Paginate from '@/Components/Table/Paginate'
import Search from '@/Components/Table/Search'

export default function Index({ presensi }) {

    const { data, meta } = presensi

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Presensi</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Data</li>
                    </ul>
                </div>
            </div>
            <div className="content">
                <div className="card mb-5 mb-xl-8">
                    <div className="card-header border-0 pt-5">
                        <h3 className="card-title align-items-start flex-column">
                            <span className="card-label fw-bolder fs-3 mb-1">Data Harian Presensi</span>
                        </h3>
                    </div>
                    <div className="card-body py-3">
                        <Search />
                        <div className="table-responsive">
                            <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-200px">
                                <thead>
                                    <tr className="fw-bolder text-muted">
                                        <th>No</th>
                                        <th>No. Pegawai<br />
                                            Nama
                                        </th>
                                        <th>
                                            Jabatan
                                        </th>
                                        <th>Tanggal</th>
                                        <th>Jam Datang</th>
                                        <th>Jam Istirahat</th>
                                        <th>Jam Pulang</th>
                                        {/* <th>Status</th> */}
                                    </tr>
                                </thead>
                                <tbody>
                                    {data && data.map((u, k) => (
                                        <tr key={k}>
                                            <td>
                                                {k + 1}
                                            </td>
                                            <td>
                                                <p>{u.nip}</p>
                                                <div className="text-dark fw-bolder text-hover-primary fs-6">{u.nama}</div>
                                            </td>
                                            <td>
                                                <div className="text-dark fw-bolder text-hover-primary fs-6">{u.jabatan}</div>
                                            </td>
                                            <td>
                                                <p>{u.tanggal}</p>
                                            </td>
                                            <td>
                                                <p>{u.jam_datang}</p>
                                            </td>
                                            <td>
                                                <p>{u.jam_istirahat}</p>
                                            </td>
                                            <td>
                                                <p>{u.jam_pulang}</p>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <Paginate meta={meta} />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

Index.layout = (page) => <Authenticated children={page} />