import Delete from '@/Components/Crud/Delete';
import Download from '@/Components/Crud/Download';
import Dropdown from '@/Components/Crud/Dropdown';
import Edit from '@/Components/Crud/Edit';
import Logs from '@/Components/Crud/Logs';
import Paginate from '@/Components/Table/Paginate';
import Search from '@/Components/Table/Search';
import Authenticated from '@/Layouts/Authenticated'
import { Link } from '@inertiajs/inertia-react'
import React from 'react'
import Detail from '../Pegawai/Detail'

export default function Index({ pegawai, Rreimbursement }) {

    const { data, meta } = Rreimbursement;

    return (
        <Detail pegawai={pegawai}>
            <div className="card card-flush mt-6 mt-xl-9">
                <div className="card-header mt-5">
                    <div className="card-title flex-column">
                        <h3 className="fw-bolder mb-1">Data reimbursement</h3>
                        <div className="fs-6 text-gray-400">Data riwayat reimbursement</div>
                    </div>
                    <div class="card-toolbar">
                        <Link preserveScroll href={route('pegawai.reimbursement.add', pegawai.nip)} class="btn btn-primary fw-bolder me-auto px-4 py-3">Tambah</Link>
                    </div>
                </div>
                <div className="card-body py-3">
                    <Search />
                    <div className="table-responsive">
                        <table className="table table-row-bordered table-row-gray-100 align-middle gs-0 gy-3 min-h-250px">
                            <thead>
                                <tr className="fw-bolder text-muted">
                                    <th className='w-10'>No</th>
                                    <th>Nama Reimbursement</th>
                                    <th>Nominal</th>
                                    <th>Nomor Surat</th>
                                    <th>Tanggal Surat</th>
                                    <th>Keterangan</th>
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
                                            <p> {u.reimbursement} </p>
                                        </td>
                                        <td>
                                            <p> {u.nilai} </p>
                                        </td>
                                        <td>
                                            <p> {u.nomor_surat} </p>
                                        </td>
                                        <td>
                                            <p>{u.tanggal_surat}</p>
                                        </td>
                                        <td>
                                            <p>{u.keterangan}</p>
                                        </td>
                                        <td>
                                            <Download file={u.file} />
                                        </td>
                                        <td>
                                            <Dropdown>
                                                <Logs model_type="App\Pegawai\DataPengajuanReimbursement" model_id={u.id} />
                                                <Edit routes={route('pegawai.reimbursement.edit', { 'pegawai': u.nip, 'Rreimbursement': u.id })} />
                                                <Delete routes={route('pegawai.reimbursement.delete', { 'pegawai': u.nip, 'Rreimbursement': u.id })} />
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