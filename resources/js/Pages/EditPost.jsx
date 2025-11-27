import NavBar from "@/Components/NavBar";
import { useState } from "react";
import { router } from "@inertiajs/react";
import Select from "react-select";
import { usePage } from "@inertiajs/react";
export default function EditPost({ post, categories }) {


  const [title, setTitle] = useState(post.title || "");
  const [content, setContent] = useState(post.content || "");
  const [thumbnail, setThumbnail] = useState(post.thumbnail || "");
  const [error, setError] = useState(null);
  const [selectedCatIds, setSelectedCatIds] = useState(
    post.categories.map((cat) => cat.id) || [],
  );

  const handleSubmit = (e) => {
    e.preventDefault();
    setError(null);

    if (!title.trim() || !content.trim()) {
      setError("Title and content are required.");
      return;
    }

    // Sử dụng Inertia router - tự động xử lý CSRF và authentication
    router.put(
      `/update-post/${post.id}`,
      {
        title,
        content,
        thumbnail,
        category_ids: selectedCatIds,
      },
      {
        onSuccess: () => {
          console.log("Post updated successfully");
          // Redirect về trang danh sách hoặc detail
          router.get("/show-posts");
        },
        onError: (errors) => {
          console.error(errors);
          setError(errors.message || "Failed to update post");
        },
      },
    );
  };

  // Convert categories => react-select format
  const categoryOptions = categories.map((cat) => ({
    value: cat.id,
    label: cat.name,
  }));

  const categoryValues = categoryOptions.filter((option) =>
    selectedCatIds.includes(option.value),
  );

  return (
    <>
      <NavBar />
      <div onSubmit={handleSubmit}>
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
            />
          </div>
          {error && <div className="mb-2 text-red-500">{error}</div>}
          <button
            type="button"
            onClick={handleSubmit}
            className="bg-[#428dfd] text-white"
          >
            Update Post
          </button>
        </div>
      </div>
    </>
  );
}
