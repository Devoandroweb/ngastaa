import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Add({ errors, status_pegawai }) {

    const [values, setValues] = useState({
        kode_status: status_pegawai.kode_status,
        nama: status_pegawai.nama,
        id: status_pegawai.id,
    })

    const updateData = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value })
    }

    const submit = (e) => {
        e.preventDefault();
        Inertia.post(route('master.status_pegawai.store'), values);
    }

    return (
        <div>
             <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Master</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-600">Status pegawai</li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
                <div className="d-flex align-items-center py-2 py-md-1" >
                    <Link href={route('master.status_pegawai.index')} className="btn btn-dark"><b>Kembali</b></Link>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5 flex">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Tambah Status pegawai</span>
                    </h3>
                </div>
                <div className="card-body py-3">
                    <form onSubmit={submit}>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Kode status</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="kode_status" disabled={values.id != undefined ? true : false} type="number" onChange={updateData} value={values.kode_status} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.kode_status && <div className="text-danger">{errors.kode_status}</div>}
                        </div>
                        <div className="row mb-6">
                            <label className="col-lg-3 col-form-label required fw-bold fs-6">Nama</label>
                            <div className="col-lg-9 fv-row fv-plugins-icon-container">
                                <input name="nama" type="text" onChange={updateData} value={values.nama} className="form-control form-control-lg form-control-solid" />
                            </div>
                            {errors.nama && <div className="text-danger">{errors.nama}</div>}
                        </div>
                        <div className="float-right">
                            <button type="submit" className="btn btn-primary">Simpan</button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    )
}

Add.layout = (page) => <Authenticated children={page} />