import { useForm } from "@inertiajs/react";
import { useEffect } from "react";
export default function Login(alertMessage) {
  const { data, setData, post, processing, errors } = useForm({
    email: "",
    password: "",
  });

  const handleSubmit = (e) => {
    e.preventDefault(); //ngan reload trang
    post("/login");
  };

  const handleEmailInput = (e) => {
    setData("email", e.target.value);
  };
  return (
    <>
      <div className="grid place-items-center p-4 sm:p-24">
        <form onSubmit={handleSubmit}>
          <div className="login_form w-[600px] border-2 p-4">
            <legend>Login Form</legend>

            {/* email */}
            <div className="mb-3 flex items-center">
              <label htmlFor="" className="w-24">
                Email:
              </label>
              <input
                type="email"
                name="username"
                id="username"
                value={data.email}
                onChange={handleEmailInput}
                placeholder="Enter your email"
                className="w-[250px] rounded-md border"
              />
              {errors.email && (
                <p className="ml-[12px] text-sm text-red-500">{errors.email}</p>
              )}
            </div>

            {/* password */}
            <div className="mb-3 flex items-center">
              <label htmlFor="" className="w-24">
                Password:
              </label>
              <input
                type="password"
                name="password"
                id="password"
                value={data.password}
                onChange={(e) => setData("password", e.target.value)}
                placeholder="Enter your password"
                className="w-[250px] rounded-md border"
              />
              {errors.password && (
                <p className="ml-[12px] text-sm text-red-500">
                  {errors.password}
                </p>
              )}
            </div>
            <div className="flex justify-center">
              <button type="submit">Log in</button>
            </div>
          </div>
        </form>
      </div>
    </>
  );
}
