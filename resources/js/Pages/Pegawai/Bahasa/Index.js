import Delete from '@/Components/Crud/Delete';
import Download from '@/Components/Crud/Download';
import Dropdown from '@/Components/Crud/Dropdown';
import Edit from '@/Components/Crud/Edit';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'
import Detail from '../Pegawai/Detail'

export default function Index({ pegawai, Rbahasa }) {

    const { data, meta } = Rbahasa;

    return (
        <Detail pegawai={pegawai}>
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Data bahasa</h3>
                        <div className="fs-6 text-gray-400">Data riwayat bahasa</div>
                    </div>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.bahasa.add', pegawai.nip)} class="btn btn-primary fw-bolder me-auto px-4 py-3">Tambah</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <Search />
                    <div className="table-responsive">
                        <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                            <thead>
                                <tr className="fw-bolder text-muted">
                                    <th className='w-10'>No</th>
                                    <th>Nama Bahasa</th>
                                    <th>Penguasaan Bahasa</th>
                                    <th>Jenis Bahasa</th>
                                    <th>Berkas</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                {data && data.map((u, k) => (
                                    <tr key={k}>
                                        <td>
                                            {k + 1}
                                        </td>
                                        <td>
                                            <p>
                                                {u.nama_bahasa}
                                            </p>
                                        </td>
                                        <td>
                                            <p>{u.penguasaan}</p>
                                        </td>
                                        <td>
                                            <p>{u.jenis}</p>
                                        </td>
                                        <td>
                                            <Download file={u.file} />
                                        </td>
                                        <td>
                                            <Dropdown>
                                                <Edit routes={route('pegawai.bahasa.edit', { 'pegawai': u.nip, 'Rbahasa': u.id })} />
                                                <Delete routes={route('pegawai.bahasa.delete', { 'pegawai': u.nip, 'Rbahasa': u.id })} />
                                            </Dropdown>
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
        </Detail>
    )
}

Index.layout = (page) => <Authenticated children={page} />