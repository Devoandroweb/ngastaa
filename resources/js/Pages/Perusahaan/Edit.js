import Authenticated from '@/Layouts/Authenticated'
import { Inertia } from '@inertiajs/inertia';
import { Link } from '@inertiajs/inertia-react';
import React, { useState } from 'react'

export default function Edit({ errors, perusahaan }) {

    const [update, setUpdate] = useState(perusahaan.id)
    const [values, setValues] = useState({
        nama: perusahaan.nama,
        logo: perusahaan.logo,
        alamat: perusahaan.alamat,
        kontak: perusahaan.kontak,
        direktur: perusahaan.direktur,
        nomor: perusahaan.nomor,
        id: perusahaan.id
    })

    const changeValue = (e) => {
        setValues({ ...values, [e.target.name]: e.target.value });
    }
    const changeImage = (e) => {
        setUpdate(null);
        setValues({ ...values, logo: e.target.files[0] });
    }

    const saveData = async (e) => {
        e.preventDefault();
        Inertia.post(route('perusahaan.update'), values);
    }

    return (
        <div>
            <div className="toolbar mb-5 mb-lg-7">
                <div className="page-title d-flex flex-column me-3">
                    <h1 className="d-flex text-dark fw-bolder my-1 fs-3">Perusahaan</h1>
                    <ul className="breadcrumb breadcrumb-dot fw-bold text-gray-600 fs-7 my-1">
                        <li className="breadcrumb-item text-gray-600">
                            <a href="/" className="text-gray-600 text-hover-primary">Home</a>
                        </li>
                        <li className="breadcrumb-item text-gray-500">Data</li>
                    </ul>
                </div>
            </div>
            <div className="card mb-5 mb-xl-8">
                <div className="card-header border-0 pt-5">
                    <h3 className="card-title align-items-start flex-column">
                        <span className="card-label fw-bolder fs-3 mb-1">Data perusahaan</span>
                    </h3>
                </div>
                <div className="card-body">
                    <form onSubmit={saveData}>
                        <div>
                            <div className="row">
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="nama" className="form-label required">Nama Perusahaan</label>
                                    <input type="text" name="nama" id="nama" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.nama} />
                                    {errors.nama && <div className="text-danger">{errors.nama}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="alamat" className="form-label required">Alamat Perusahaan</label>
                                    <textarea name="alamat" id="alamat" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.alamat} rows="4" />
                                    {errors.alamat && <div className="text-danger">{errors.alamat}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="kontak" className="form-label required">Kontak Perusahaan</label>
                                    <textarea name="kontak" id="kontak" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.kontak} rows="4" />
                                    {errors.kontak && <div className="text-danger">{errors.kontak}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="direktur" className="form-label required">Direktur Perusahaan</label>
                                    <input type="text" name="direktur" id="direktur" required className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.direktur} />
                                    {errors.direktur && <div className="text-danger">{errors.direktur}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="nomor" className="form-label">Nomor Pegawai Direktur</label>
                                    <input type="text" name="nomor" id="nomor" className="mt-1 form-control form-control-lg form-control-solid" onChange={changeValue} value={values.nomor} />
                                    {errors.nomor && <div className="text-danger">{errors.nomor}</div>}
                                </div>
                                <div className="col-lg-12 mb-4">
                                    <label htmlFor="logo" className="form-label required">Logo Perusahaan</label>
                                    {
                                        values.logo == undefined || values.logo == '' ? ''
                                            :
                                            <div>
                                                <img src={update === null || update === undefined ? URL.createObjectURL(values.logo) : "/storage/" + values.logo} width={250} height={250} alt="logo" />
                                            </div>
                                    }
                                    <input onChange={changeImage} type="file" name="logo" id="logo" className="mt-1 form-control" />
                                {errors.logo && <div className="text-danger">{errors.logo}</div>}
                                </div>
                            </div>
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

Edit.layout = (page) => <Authenticated children={page} />