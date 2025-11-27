import NavBar from "@/Components/NavBar";
import { router, usePage } from "@inertiajs/react";
import { useState } from "react";
import Select from "react-select";

export default function CreatePost({ user, token, categories }) {
  const [title, setTitle] = useState("");
  const [content, setContent] = useState("");
  const [thumbnail, setThumbnail] = useState("");
  const [error, setError] = useState(null);
  const [selectedCatIds, setSelectedCatIds] = useState([]);

  const handleSubmit = async (e) => {
    setError(null);

    if (!title.trim() || !content.trim()) {
      setError("Title and content are required.");
      return;
    }
    try {
      const headers = {
        Accept: "application/json",
        "Content-Type": "application/json",
      };

      if (token) {
        headers["Authorization"] = `Bearer ${token}`;
      } else {
        // attempt to initialize CSRF cookie so session-based auth works
        await fetch("/sanctum/csrf-cookie", {
          credentials: "include",
        });
      }
      console.log("categories bao gom:", selectedCatIds);

      const res = await fetch("/api/posts/add-post", {
        method: "POST",
        headers,
        body: JSON.stringify({
          title,
          content,
          thumbnail,
          category_ids: selectedCatIds,
        }),
        credentials: token ? "omit" : "include",
      });

      if (!res.ok) {
        const text = await res.text();
        throw new Error(text || `Request failed with status ${res.status}`);
      }

      const data = await res.json();
      console.log("Post created:", data);
      router.get("/create-post");
    } catch (err) {
      console.error(err);
      setError(err.message || "Failed to create post");
    }
  };

  //Convert categories => react-select format  =====> for option
  const categoryOptions = categories.map((cat) => ({
    value: cat.id,
    label: cat.name,
  }));

  // =====> for value
  const categoryValues = categoryOptions.filter((option) =>
    selectedCatIds.includes(option.value),
  );

  return (
    <>
      <NavBar />
      <form onSubmit={handleSubmit}>
        <div className="create-post max-w-96">
          <div className="create-post__container">
            <label htmlFor="title">Title:</label>
            <input
              type="text"
              name="title"
              id="title"
              value={title}
              onChange={(e) => setTitle(e.target.value)}
            />
          </div>
          <div className="">
            <label htmlFor="content">Content:</label>
            <div className="w-full">
              <textarea
                name="content"
                id="content"
                rows="5"
                placeholder="Please enter content"
                value={content}
                className="w-full"
                onChange={(e) => setContent(e.target.value)}
              ></textarea>
            </div>
          </div>
          <div className="">
            <label htmlFor="thumbnail">Thumbnail(URL):</label>
            <input
              type="text"
              name="thumbnail"
              id="thumbnail"
              placeholder="Please enter thumbnail"
              value={thumbnail}
              onChange={(e) => setThumbnail(e.target.value)}
            />
          </div>
          <div>
            <label htmlFor="category">Categories: </label>
            <Select
              name="Categories"
              isMulti={true}
              options={categoryOptions}
              value={categoryValues}
              styles={{
                control: (base) => ({
                  ...base,
                  cursor: "pointer",
                }),
                option: (base) => ({
                  ...base,
                  cursor: "pointer",
                }),
              }}
              onChange={(selected) => {
                const ids = selected ? selected.map((opt) => opt.value) : [];
                setSelectedCatIds(ids);
              }}
            ></Select>
          </div>
          {error && <div className="mb-2 text-red-500">{error}</div>}
          <button type="submit" className="bg-[#428dfd] text-white">
            Submit
          </button>
        </div>
      </form>
    </>
  );
}
