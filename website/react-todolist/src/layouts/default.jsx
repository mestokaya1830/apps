import {Outlet} from 'react-router-dom'

export default function Default() {
  return (
    <>
      <main className='router'>
        <Outlet />
      </main>
    </>
  )
}
